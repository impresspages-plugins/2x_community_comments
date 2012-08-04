<?php
/**
 * @package   ImpressPages
 * @copyright Copyright (C) 2012 JSC Apro Media.
 * @license   GNU/GPL, see ip_license.html
 */

namespace Modules\community\comments;


class Db{

  public static function insertComment($languageId, $zoneName, $pageId, $userId, $name, $email, $link, $text, $ip, $sessionId, $confirmationCode, $approved = 0){
    
    if($userId !== null){
      $userIdSql = " ".(int)$userId." "; 
    } else {
      $userIdSql = " null ";
    }
    
    $sql = "insert into `".DB_PREF."m_community_comment` 
    set 
    `language_id` = '".(int)$languageId."',
    `zone_name` = '".mysql_real_escape_string($zoneName)."',
    `page_id` = '".mysql_real_escape_string($pageId)."',
    `user_id` = ".$userIdSql.",
    `name` = '".mysql_real_escape_string($name)."',
    `email` = '".mysql_real_escape_string($email)."',
    `link` = '".mysql_real_escape_string($link)."',
    `text` = '".mysql_real_escape_string($text)."',
    `ip` = '".mysql_real_escape_string($ip)."',
    `session_id` = '".mysql_real_escape_string($sessionId)."',
    `approved` = '".(int)$approved."',
    `verification_code` = '".mysql_real_escape_string($confirmationCode)."',
    `created` = UTC_TIMESTAMP,
    `modified` = UTC_TIMESTAMP";
    $rs = mysql_query($sql);
    if(!$rs){
      trigger_error($sql.' '.mysql_error());
      return false;
    } else {
      return mysql_insert_id();
    }
    
  
  }

  public static function getCommentsCount($languageId, $zoneName, $pageId, $includeOnlyApproved = true){
    $sql = "select count(*) as 'count' from `".DB_PREF."m_community_comment`  
    where 
    `language_id` = '".(int)$languageId."' and
    `zone_name` = '".mysql_real_escape_string($zoneName)."' and
    `page_id` = '".(int)$pageId."'
    ";
    
    if($includeOnlyApproved){
      $sql .= ' and `approved` ';
    }
    
    $rs = mysql_query($sql);
    if($rs){
      if($lock = mysql_fetch_assoc($rs)){
        return $lock['count'];
      } else {
        return false;
      }      
    }else{
      trigger_error($sql." ".mysql_error());
    }
    return false;
  }
  
  
  public static function getComments($languageId, $zoneName, $pageId, $order = 'asc'){
    $sql = "select * from `".DB_PREF."m_community_comment`  
    where 
    `language_id` = '".(int)$languageId."' and
    `zone_name` = '".mysql_real_escape_string($zoneName)."' and
    `page_id` = '".(int)$pageId."'
    ";
    
    if($order = 'asc'){
      $sql .= ' order by `id` asc'; 
    } else {
      $sql .= ' order by `id` desc'; 
    }
    
    
    $rs = mysql_query($sql);
    if($rs){
      $answer = array();
      while($lock = mysql_fetch_assoc($rs)){
        $answer[] = $lock;
      }
      return $answer;      
    }else{
      trigger_error($sql." ".mysql_error());
    }
    return false;
  }
  
  
  public static function deleteComments($languageId, $zoneName, $pageId){
    $sql = "delete from `".DB_PREF."m_community_comment`  
    where 
    `language_id` = '".(int)$languageId."' and
    `zone_name` = '".mysql_real_escape_string($zoneName)."' and
    `page_id` = '".(int)$pageId."'
    ";
    
    
    
    $rs = mysql_query($sql);
    if($rs){      
      return mysql_affected_rows();      
    }else{
      trigger_error($sql." ".mysql_error());
    }
    return false;
  }  
  
  public static function approveComment($id, $verificationCode){
    $sql = "update `".DB_PREF."m_community_comment` set approved = 1 
    where `id` = ".(int)$id." and `verification_code` = '".mysql_real_escape_string($verificationCode)."' ";
    $rs = mysql_query($sql);
    if(!$rs){
      trigger_error($sql.' '.mysql_error());
      return false;
    } else {
      return mysql_affected_rows();
    }    
  }
  
  public static function hideComment($id, $verificationCode){
    $sql = "update `".DB_PREF."m_community_comment` set approved = 0 
    where `id` = ".(int)$id." and `verification_code` = '".mysql_real_escape_string($verificationCode)."' ";
    $rs = mysql_query($sql);
    if(!$rs){
      trigger_error($sql.' '.mysql_error());
      return false;
    } else {
      return mysql_affected_rows();
    }    
  }
  
  
  public static function getComment($id){
    $sql = "select * from `".DB_PREF."m_community_comment`  
    where `id` = '".(int)$id."'
    ";
    

    $rs = mysql_query($sql);
    if($rs){
      if($lock = mysql_fetch_assoc($rs)){
        return $lock;
      } else {
        return false;
      }      
    }else{
      trigger_error($sql." ".mysql_error());
    }
    return false;    
  }
  
  public static function commentsLastMinutes($minutes, $ip = null){
    $sql = "select * from `".DB_PREF."m_community_comment`  
    where 
    `created` > date_sub(UTC_TIMESTAMP, INTERVAL ".(int)$minutes." MINUTE)
    ";
    
    if($ip !== null){
      $sql .= " and `ip` = '".mysql_real_escape_string($ip)."' ";
    }

    $rs = mysql_query($sql);
    if($rs){
      $answer = array();
      while($lock = mysql_fetch_assoc($rs)){
        $answer[] = $lock;
      }
      return $answer;      
    }else{
      trigger_error($sql." ".mysql_error());
    }
    return false;    
  }
  
  public static function getAllComments(){
    $sql = "select * from `".DB_PREF."m_community_comment`  
    where 
    1
    ";
    
    $rs = mysql_query($sql);
    if($rs){
      $answer = array();
      while($lock = mysql_fetch_assoc($rs)){
        $answer[] = $lock;
      }
      return $answer;      
    }else{
      trigger_error($sql." ".mysql_error());
    }
    return false;    
  }  
  
}
