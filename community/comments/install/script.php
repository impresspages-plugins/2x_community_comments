<?php
/**
 * @package   ImpressPages
 * @copyright Copyright (C) 2009 JSC Apro media.
 * @license   GNU/GPL, see ip_license.html
 */
namespace Modules\community\comments;

if (!defined('CMS')) exit;

class Install{

  public function execute(){

    
    $sql="
    CREATE TABLE IF NOT EXISTS `".DB_PREF."m_community_comment` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `language_id` int(11) NOT NULL,
      `zone_name` varchar(255) NOT NULL,
      `page_id` int(11) NOT NULL,
      `user_id` int(11) DEFAULT NULL,
      `name` varchar(255) NOT NULL,
      `email` varchar(255) DEFAULT NULL,
      `link` varchar(255) DEFAULT NULL,
      `text` text NOT NULL,
      `ip` varchar(39) NOT NULL,
      `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
      `approved` tinyint(1) NOT NULL,
      `session_id` varchar(255) NOT NULL COMMENT 'to show the post before it is approved',
      `verification_code` varchar(32) NOT NULL,
      PRIMARY KEY (`id`),
      KEY `user_id` (`user_id`),
      KEY `page_id` (`page_id`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;
    ";
    
    $rs = mysql_query($sql);
    
    if(!$rs){ 
      trigger_error($sql." ".mysql_error());
    }
    

    $sql = "ALTER TABLE `".DB_PREF."m_community_comment` ADD INDEX ( `language_id` , `zone_name` , `page_id` ) ;";
    
    $rs = mysql_query($sql);
    
    if(!$rs){ 
      trigger_error($sql." ".mysql_error());
    }
    
    


  }
} 
  
