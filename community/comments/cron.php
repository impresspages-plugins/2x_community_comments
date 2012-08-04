<?php
/**
 * @package   ImpressPages
 * @copyright Copyright (C) 2009 JSC Apro media.
 * @license   GNU/GPL, see ip_license.html
 */
 
namespace Modules\community\comments;  

if (!defined('CMS')) exit;


class Cron{
  function execute($options){
    global $parametersMod;
    global $log;
    global $site;
    if($options->firstTimeThisMonth){
      require_once(BASE_DIR.PLUGIN_DIR.'community/comments/db.php');
      $comments = Db::getAllComments();
      $pages = array();
      foreach($comments as $key => $comment){
        $pages[$comment['language_id']][$comment['zone_name']][$comment['page_id']][] = $comment['id'];
      }
      
      foreach($pages as $languageId => $language){
        foreach($language as $zoneName => $zone){
          foreach($zone as $pageId => $comments){
            $zone = $site->getZone($zoneName);
            if($zone){
              $page = $zone->getElement($pageId);
              if(!$page){
                Db::deleteComments($languageId, $zoneName, $pageId);
              }
            }
          }
        }
      }
      
    }
      
  }
}




