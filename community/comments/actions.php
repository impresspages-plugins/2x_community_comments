<?php
/**
 * @package   ImpressPages
 * @copyright Copyright (C) 2009 JSC Apro media.
 * @license   GNU/GPL, see ip_license.html
 */

namespace Modules\community\comments;

if (!defined('CMS')) exit;

global $site;
$site->requireConfig('community/comments/config.php');

require_once(BASE_DIR.PLUGIN_DIR.'community/comments/db.php');

class Actions{

  function makeActions(){
    global $site;
    global $parametersMod;
    global $session;
    global $db;
    global $log;


    if(isset($_REQUEST['action'])){
      switch($_REQUEST['action']){
        case 'comment':
          require_once(BASE_DIR.LIBRARY_DIR.'php/text/system_variables.php');
          require_once(BASE_DIR.LIBRARY_DIR.'php/text/html_transform.php');          
          
          $standardForm = new \Library\Php\Form\Standard(Config::getFields());
          $errors = $standardForm->getErrors();
          
          $globalError = null;
          
          $in5Min = Db::commentsLastMinutes(5, $_SERVER['REMOTE_ADDR']);
          $in60Min = Db::commentsLastMinutes(60, $_SERVER['REMOTE_ADDR']);
          $limit5 = $parametersMod->getValue('community', 'comments', 'options', 'limit_in_5_min');
          $limit60 = $parametersMod->getValue('community', 'comments', 'options', 'limit_in_60_min');
          if($limit5 != 0 && sizeof($in5Min) >= $limit5 || $limit60 != 0 && sizeof($in60Min) >= $limit60){
            $globalError = $parametersMod->getValue('community', 'comments', 'translations', 'error_comments_limit');
          }
          
          
          if(sizeof($errors) > 0 || $standardForm->detectSpam() || $globalError){
            $html = $standardForm->generateErrorAnswer($errors, $globalError);
          }else{   
            if($session->userId() !== false){
              $userId = $session->userId();
            } else {
              $userId = null;
            }
            
            $_SESSION['modules']['community']['comments']['last_name'] = $_POST['name'];
            $_SESSION['modules']['community']['comments']['last_email'] = $_POST['email'];
            $_SESSION['modules']['community']['comments']['last_link'] = $_POST['link'];
            
            
            if($_POST['link'] !== '' and strpos($_POST['link'], 'https://') !== 0 and strpos($_POST['link'], 'http://') !== 0){
              $_POST['link'] = 'http://'.$_POST['link'];
            }
            
            
            $verificationCode = md5(uniqid(rand(), true));
            
            $approved = !$parametersMod->getValue('community', 'comments', 'options', 'require_admin_confirmation');
            
            $commentId = Db::insertComment(
            $languageId = $_POST['language_id'],
            $zoneName = $_POST['zone_name'], 
            $pageId = $_POST['page_id'], 
            $userId = $userId, 
            $name = $_POST['name'], 
            $email = $_POST['email'], 
            $link = $_POST['link'], 
            $text = $_POST['text'], 
            $ip = $_SERVER['REMOTE_ADDR'], 
            $sessionId = session_id(),
            $verificationCode = $verificationCode, 
            $approved = $approved);

            
            $html = Config::getAnswer($_REQUEST['spec_rand_name'], $commentId, $languageId, $zoneName, $pageId);            
            
            if($parametersMod->getValue('community', 'comments', 'options', 'inform_about_new_comments')){
              $this->sendConfirmationEmail($_POST, $commentId, $verificationCode);
            }
          
            $site->dispatchEvent('community', 'comments', 'new_comment2', array('data'=>$_POST));
            if(!$parametersMod->getValue('community', 'comments', 'options', 'require_admin_confirmation')){
              $site->dispatchEvent('community', 'comments', 'comment_approwed2', array('id'=>$commentId));
            }            
            
          }
          echo $html;
          

          
          \Db::disconnect();
          exit;
          break;
          case 'approve_comment':
            if(isset($_REQUEST['id']) && isset($_REQUEST['code'])){
              $affectedRows = Db::approveComment($_REQUEST['id'], $_REQUEST['code']);
              if($affectedRows){
                $site->dispatchEvent('community', 'comments', 'comment_approwed', array('id'=>$_REQUEST['id']));
              }
            }  
          break;
          case 'hide_comment':
            if(isset($_REQUEST['id']) && isset($_REQUEST['code'])){
              $affectedRows = Db::hideComment($_REQUEST['id'], $_REQUEST['code']);
              if($affectedRows){
                $site->dispatchEvent('community', 'comments', 'comment_disapprowed', array('id'=>$_REQUEST['id']));
              }
            }  
          break;
          case 'redirect_to_anchor':
           $zone = $site->getZone($_REQUEST['zone_name']);
           $element = $zone->getElement($_REQUEST['page_id']);
           header('Location: '.$element->getLink().'#ipComment-'.$_REQUEST['comment_id']);
           \Db::disconnect();
           exit;                 
          break;
          
      }
    }
  }


  private function sendConfirmationEmail($postData, $commentId, $verificationCode){
    global $site;
    global $parametersMod;
    require_once (BASE_DIR.MODULE_DIR.'administrator/email_queue/module.php');
    $site->requireTemplate('community/comments/template.php');
    
    $zone = $site->getZone($postData['zone_name']);
    if($zone){
      $element = $zone->getElement($postData['page_id']);
      if($element){
        $link = $element->getLink();
      } else {
        $link = $site->generateUrl();
      }
    } else {
      $link = $site->generateUrl();
    }            
    
    $approveLink = $link;
    if(strpos($approveLink, '?') === false){
      $approveLink = $approveLink.'?module_group=community&module_name=comments&action=approve_comment&id='.$commentId.'&code='.$verificationCode.'#ipComment-'.$commentId;
    } else {
      $approveLink = $approveLink.'&module_group=community&module_name=comments&action=approve_comment&id='.$commentId.'&code='.$verificationCode.'#ipComment-'.$commentId;
    }
   
    $hideLink = $link;
    if(strpos($hideLink, '?') === false){
      $hideLink = $hideLink.'?module_group=community&module_name=comments&action=hide_comment&id='.$commentId.'&code='.$verificationCode;
    } else {
      $hideLink = $hideLink.'&module_group=community&module_name=comments&action=hide_comment&id='.$commentId.'&code='.$verificationCode;
    }
    
    if($parametersMod->getValue('community', 'comments', 'options', 'require_admin_confirmation')){
      $emailHtml = $parametersMod->getValue('community', 'comments', 'email_translations', 'new_comment_text_approve');
    } else {
      $emailHtml = $parametersMod->getValue('community', 'comments', 'email_translations', 'new_comment_text_hide');
    }
    $emailHtml = str_replace('[[link]]', '<a href="'.$link.'">'.\Library\Php\Text\HtmlTransform::prepareLink($link).'</a>', $emailHtml);
    $emailHtml = str_replace('[[approve_link]]', '<a href="'.$approveLink.'">'.\Library\Php\Text\HtmlTransform::prepareLink($approveLink).'</a>', $emailHtml);
    $emailHtml = str_replace('[[hide_link]]', '<a href="'.$hideLink.'">'.\Library\Php\Text\HtmlTransform::prepareLink($hideLink).'</a>', $emailHtml);
    
    $comment = '';
    $comment .= '<strong>'.htmlspecialchars($parametersMod->getValue('community', 'comments', 'translations', 'name')).':</strong> '.$postData['name'].'<br/>';
    $comment .= '<strong>'.htmlspecialchars($parametersMod->getValue('community', 'comments', 'translations', 'email')).':</strong> <a href="mailto:'.$postData['email'].'">'.$postData['email'].'</a><br/>';
    $comment .= '<strong>'.htmlspecialchars($parametersMod->getValue('community', 'comments', 'translations', 'link')).':</strong> <a href="'.$postData['link'].'">'.$postData['link'].'</a><br/>';
    $comment .= '<strong>'.htmlspecialchars($parametersMod->getValue('community', 'comments', 'translations', 'text')).':</strong> <br/>'.str_replace("\n", "<br/>", htmlspecialchars($postData['text']));
    
    $emailHtml = str_replace('[[comment]]', $comment, $emailHtml);
    
    
    $emailHtml = str_replace('[[content]]', $emailHtml, $parametersMod->getValue('standard', 'configuration', 'main_parameters', 'email_template')); 
    $emailHtml = \Library\Php\Text\SystemVariables::insert($emailHtml);
    $emailHtml = \Library\Php\Text\SystemVariables::clear($emailHtml);
    
    
    $emailQueue = new \Modules\administrator\email_queue\Module();
    
    if($parametersMod->getValue('community', 'comments', 'options', 'use_separate_email') != ''){
      $toEmail = $parametersMod->getValue('community', 'comments', 'options', 'use_separate_email');
    } else {
      $toEmail = $parametersMod->getValue('standard', 'configuration', 'main_parameters', 'email');
    }
    
    $email = $parametersMod->getValue('standard', 'configuration', 'main_parameters', 'email');

    $name = $parametersMod->getValue('standard', 'configuration', 'main_parameters', 'name');
    
    $emailQueue->addEmail(
    $email,
    $name,
    $toEmail,
    '',
    $parametersMod->getValue('community', 'comments', 'email_translations', 'new_comment_subject'),
    $emailHtml,
    true, true, null);
    $emailQueue->send();
  }



}


 
