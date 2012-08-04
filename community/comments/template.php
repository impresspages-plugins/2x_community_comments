<?php
/**
 * @package   ImpressPages
 * @copyright Copyright (C) 2009 JSC Apro media.
 * @license   GNU/GPL, see ip_license.html
 */

namespace Modules\community\comments;

if (!defined('CMS')) exit;


class Template{

  public static function generateComments($comments){
    global $parametersMod;
    $answer = '';
    
    if(sizeof($comments) == 0){
      return '';
    }
    
    $answer = '
<div class="ipWidget ipWidgetTitle ipModuleCommunityCommentsTitle">
  <h3 class="ipWidgetTitleHeading">
    '.htmlspecialchars($parametersMod->getValue('community', 'comments', 'translations', 'comments')).'
  </h3>
</div>
';
    
    $list = '';
    
    foreach($comments as $key => $comment){
      
      if($comment['approved']){
        $class = '';
        $awaitingModeration = '';
      } else {
        $class = 'notApproved';
        $awaitingModeration = '<em>'.htmlspecialchars($parametersMod->getValue('community', 'comments', 'translations', 'awaiting_moderation')).'</em>';
      }
            
      if($key%2 == 0){
        $class .= ' ipModuleCommunityCommentsEven';
      }
      
      if($comment['link']){
        $name = '<a rel="external nofollow" href="'.htmlspecialchars($comment['link']).'">'.htmlspecialchars($comment['name']).'</a>'; 
      } else {
        $name = ''.htmlspecialchars($comment['name']).''; 
      }
      
      $list .= '
  <li id="ipComment-'.$comment['id'].'" class="'.$class.'">
    <cite>
      '.$name.'
    </cite>
    '.htmlspecialchars($parametersMod->getValue('community', 'comments', 'translations', 'says')).'
    '.$awaitingModeration.'
    <br/>
    <small class="commentMetaData">
      <a href="#ipComment-'.$comment['id'].'">
        '.date("Y-m-d G:i", strtotime($comment['created'])).'
      </a>
    </small>
    <p>
      '.str_replace("\n", '<br/>', htmlspecialchars($comment['text'])).'
    </p>
  </li>
';
    }
    
    $answer .= '
<ol class="ipModuleCommunityComments">
'.$list.'
</ol>
';
    
    return $answer;
  }
  
  public static function generateForm($fields){
    global $parametersMod;
    
    require_once(BASE_DIR.LIBRARY_DIR.'php/form/standard.php');
    $answer = '';
    
    $answer .= '
<div class="ipWidget ipWidgetTitle ipModuleCommunityCommentsTitle">
  <h3 class="ipWidgetTitleHeading">
    '.htmlspecialchars($parametersMod->getValue('community', 'comments', 'translations', 'comment')).'
  </h3>
</div>
';
    
    $standardForm = new \Library\Php\Form\Standard($fields);
    $form = $standardForm->generateForm($parametersMod->getValue('community', 'comments', 'translations', 'send'));
    $answer .= '
<div class="ipWidget ipWidgetContactForm">
'.$form.'
</div>
';    
    return $answer;
  }
  

  
}