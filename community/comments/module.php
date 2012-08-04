<?php
/**
 * @package   ImpressPages
 * @copyright Copyright (C) 2009 JSC Apro media.
 * @license   GNU/GPL, see license.html
 */
namespace Modules\community\comments;

if (!defined('CMS')) exit;


class Module{
  
  public function generateComments($languageId = null, $zoneName = null, $pageId = null, $start = 0, $limit = null){
    global $site;
    
    require_once(__DIR__.'/db.php');
    $site->requireTemplate('community/comments/template.php');
    
    $answer = '';
    
    if($languageId === null){
      $languageId = $site->currentLanguage['id'];
    }
    
    if($zoneName === null){
      $zoneName = $site->getCurrentZoneName();
    }
    
    if($pageId === null){
      $pageId = $site->getCurrentElement()->getId();
    }
    
    
    
    $zone = $site->getZone($zoneName);
    
    $allComments = Db::getComments($languageId, $zoneName, $pageId);
    
    $comments = array();

    foreach($allComments as $key => $comment){
      if($comment['approved'] || $comment['session_id'] == session_id()){
        $comments[] = $comment;
      }
    }
    
    $answer = Template::generateComments($comments);
    
    
    
    return $answer;
  }
  
  
  public function generateForm($languageId = null, $zoneName = null, $pageId = null){
    global $site;
    
    $site->requireConfig('community/comments/config.php');
    $site->requireTemplate('community/comments/template.php');    
    require_once(BASE_DIR.LIBRARY_DIR.'php/form/standard.php');
    
    $answer = '';
    
    if($languageId === null){
      $languageId = $site->currentLanguage['id'];
    }
    
    if($zoneName === null){
      $zoneName = $site->getCurrentZoneName();
    }
    
    if($pageId === null){
      $pageId = $site->getCurrentElement()->getId();
    }
    
    
    $fields = Config::getFields();
    
    $field =  new \Library\Php\Form\FieldHidden();
    $field->name = 'module_group';
    $field->value = 'community';
    $fields[] = $field;  

    $field =  new \Library\Php\Form\FieldHidden();
    $field->name = 'module_name';
    $field->value = 'comments';
    $fields[] = $field;  
    
    $field =  new \Library\Php\Form\FieldHidden();
    $field->name = 'action';
    $field->value = 'comment';
    $fields[] = $field;  
    
    
    $field =  new \Library\Php\Form\FieldHidden();
    $field->name = 'language_id';
    $field->value = $site->currentLanguage['id'];
    $fields[] = $field;  

    $field =  new \Library\Php\Form\FieldHidden();
    $field->name = 'zone_name';
    $field->value = $site->getCurrentZoneName();
    $fields[] = $field;  

    $field =  new \Library\Php\Form\FieldHidden();
    $field->name = 'page_id';
    $field->value = $site->getCurrentElement()->getId();
    $fields[] = $field;      
            
            
            
    
    
    $answer = Template::generateForm($fields);
    /*$site->requireTemplate('commuinty/comments/template.php');
    
    $zone = $site->getZone($zoneName);
    $elements = $zone->getElements(null, null, $start, $limit, false, true);
    $elements = array_reverse($elements);
    $answer = Template::generateBlog($elements);
    */
    //$answer .= $languageId.' '.$zoneName.' '.$pageId;
    
    return $answer;
  }  

  
}