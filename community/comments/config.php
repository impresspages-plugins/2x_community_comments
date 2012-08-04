<?php
/**
 * @package   ImpressPages
 * @copyright Copyright (C) 2009 JSC Apro media.
 * @license   GNU/GPL, see ip_license.html
 */
namespace Modules\community\comments;

if (!defined('CMS')) exit;

require_once(BASE_DIR.LIBRARY_DIR.'php/form/standard.php');

/**
 * User area (registration) configuration.
 * @package ImpressPages
 */

class Config{


  /** @var array fields, that are used for registration */
  public static function getFields(){
    /** private*/
    global $parametersMod;
    /** private*/
    global $session;
    /** private*/
    global $site;
    

    $fields = array();
    
      
    
    $field = new \Library\Php\Form\FieldText();
    $field->name = 'name';
    $field->dbField = 'name';
    $field->caption = $parametersMod->getValue('community', 'comments', 'translations', 'name');
    $field->required = true;
    if(isset($_SESSION['modules']['community']['comments']['last_name'])){
      $field->value = $_SESSION['modules']['community']['comments']['last_name'];
    }
    $fields[] = $field;
    
    $field = new \Library\Php\Form\FieldEmail();
    $field->name = 'email';
    $field->dbField = 'email';
    $field->caption = $parametersMod->getValue('community', 'comments', 'translations', 'email');
    $field->note = $parametersMod->getValue('community', 'comments', 'translations', 'email_note');
    $field->required = true;
    if(isset($_SESSION['modules']['community']['comments']['last_email'])){
      $field->value = $_SESSION['modules']['community']['comments']['last_email'];
    }
    $fields[] = $field;

    $field = new \Library\Php\Form\FieldText();
    $field->name = 'link';
    $field->dbField = 'link';
    $field->caption = $parametersMod->getValue('community', 'comments', 'translations', 'link');
    $field->required = false;
    if(isset($_SESSION['modules']['community']['comments']['last_link'])){
      $field->value = $_SESSION['modules']['community']['comments']['last_link'];
    }    
    $fields[] = $field;
    

    if($parametersMod->getValue('community', 'comments', 'options', 'use_captcha')){
      $field = new \Library\Php\Form\FieldCaptcha();
      $field->name = 'captcha';
      $field->caption = $parametersMod->getValue('community', 'comments', 'translations', 'captcha');
      $field->required = true;
      $fields[] = $field;
    }
    
 
    
    $field = new \Library\Php\Form\FieldTextarea();
    $field->name = 'text';
    $field->dbField = 'text';
    $field->caption = $parametersMod->getValue('community', 'comments', 'translations', 'text');
    $field->required = true;
    $fields[] = $field;    


    return $fields;
  }

  //generate answer. He will be sent to iframe.
   public static function getAnswer($formId, $commentId, $languageId, $zoneName, $pageId){ 
     global $site;

     
     $zone = $site->getZone($zoneName);
     $element = $zone->getElement($pageId);     

     $parameters = array(
        'module_group' => 'community',
        'module_name' => 'comments',
        'action' => 'redirect_to_anchor',
        'language_id' => $languageId,
        'zone_name' => $zoneName,
        'page_id' => $pageId,
        'comment_id' => $commentId     
     );
     
     $html = '
     <html><head><meta http-equiv="Content-Type" content="text/html; charset='.CHARSET.'" /></head><body>
     <script type="text/javascript">
       link = "'.$site->generateUrl($languageId, $zoneName, null, $parameters).'";
       link = link.replace(/&amp;/g, "&");  
       parent.window.location.href = link; //double redirect to hack IE reload bug
     </script>     
     </body></html>';     
     return $html;

   }
   


}
