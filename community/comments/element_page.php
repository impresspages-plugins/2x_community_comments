<?php
/**
 * @package   ImpressPages
 * @copyright Copyright (C) 2009 JSC Apro media.
 * @license   GNU/GPL, see ip_license.html
 */
namespace Modules\community\comments;

if (!defined('CMS')) exit;

class ElementPage extends \Modules\developer\std_mod\ElementText{
  

  function __construct($variables){
    
    $variables['visibleOnInsert'] = false;
    $variables['visibleOnUpdate'] = false;
    $variables['order'] = false;
    
    if(!isset($variables['previewLength'])){
      $variables['previewLength'] = 30;
    }
    
    parent::__construct($variables);
  } 
  
  function previewValue($record, $area){
    require_once(BASE_DIR.LIBRARY_DIR.'php/text/string.php');
    global $parametersMod;
    global $site;

    $zone = $site->getZone($record['zone_name']);
    if($zone){
      $element = $zone->getElement($record['page_id']);
      if($element){
        $link = $element->getLink();
      } else {
        $link = $site->generateUrl();
      }
    } else {
      $link = $site->generateUrl();
    } 
    
    $linkStr = substr($link, strlen(BASE_URL) - 1);
    $linkStr = mb_substr($linkStr, 0, $this->previewLength);
    $linkStr = htmlspecialchars($linkStr);
    $linkStr = \Library\Php\Text\String::mb_wordwrap($linkStr, 10, "&#x200B;", 1);       
    
    return '<a href="'.$link.'" target="_blank">'.$linkStr.'</a>';

    
  }
  
  function printFieldUpdate($prefix, $record, $area){
    return '';  
  }
   
  function printFieldNew($prefix, $parentId = null, $area = null){
    return '';  
  }
  
  

}