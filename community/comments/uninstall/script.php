<?php
/**
 * @package   ImpressPages
 * @copyright Copyright (C) 2009 JSC Apro media.
 * @license   GNU/GPL, see ip_license.html
 */
namespace Modules\community\comments;

if (!defined('CMS')) exit;

class Uninstall{

  public function execute(){
    
    $sql="
    DROP TABLE IF EXISTS `".DB_PREF."m_community_comment`;
    ";
    
    $rs = mysql_query($sql);
    
    if(!$rs){ 
      trigger_error($sql." ".mysql_error());
    }
    
  }
}

