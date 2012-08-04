<?php
/**
 * @package   ImpressPages
 * @copyright Copyright (C) 2012 JSC Apro Media.
 * @license   GNU/GPL, see ip_license.html
 */

namespace Modules\community\comments;


require_once(BASE_DIR.MODULE_DIR.'developer/std_mod/std_mod.php');
require_once(BASE_DIR.PLUGIN_DIR.'community/comments/element_page.php');

class CommentsArea extends \Modules\developer\std_mod\Area{
  protected $configObjects;
  function __construct(){    
    global $parametersMod;
    parent::__construct(
      array(
      'title' => $parametersMod->getValue('community', 'comments', 'admin_translations', 'comments'),
      'dbTable' => 'm_community_comment',
      'dbPrimaryKey' => 'id',
      'searchable' => true,
      'orderBy' => 'id',
      'sortable' => false,
      'allowInsert' => false
      )    
    );
    
    
    $element = new \Modules\developer\std_mod\ElementNumber(
    array(
    'title' => $parametersMod->getValue('community', 'comments', 'admin_translations', 'id'),
    'dbField' => 'id',
    'showOnList' => true,
    'searchable' => true,
    'defaultValue' => true,
    'disabledOnUpdate' => true, 
    'order' => true 
    )
    );
    $this->addElement($element);    


    $element = new \Modules\developer\std_mod\ElementText(
    array(
    'title' => $parametersMod->getValue('community', 'comments', 'admin_translations', 'name'),
    'dbField' => 'name',
    'showOnList' => true,
    'searchable' => true, 
    'order' => true
    )
    );
    $this->addElement($element);        
        
    $element = new \Modules\developer\std_mod\ElementText(
    array(
    'title' => $parametersMod->getValue('community', 'comments', 'admin_translations', 'link'),
    'dbField' => 'link',
    'showOnList' => true,
    'searchable' => true, 
    'order' => true
    )
    );
    $this->addElement($element);        
    
    
    $element = new \Modules\developer\std_mod\ElementText(
    array(
    'title' => $parametersMod->getValue('community', 'comments', 'admin_translations', 'email'),
    'dbField' => 'email',
    'showOnList' => true,
    'searchable' => true,
    'regExpression' => $parametersMod->getValue('developer','std_mod','parameters','email_reg_expression'),
    'regExpressionError' => $parametersMod->getValue('developer','std_mod','admin_translations','error_email'), 
    'order' => true
    )
    );
    $this->addElement($element);        
    
    
    
    $element = new \Modules\developer\std_mod\ElementTextarea(
    array(
    'title' => $parametersMod->getValue('community', 'comments', 'admin_translations', 'comment'),
    'dbField' => 'text',
    'showOnList' => true,
    'searchable' => true, 
    'order' => true
    )
    );
    $this->addElement($element);        
    
    
    $element = new ElementPage(
    array(
    'title' => $parametersMod->getValue('community', 'comments', 'admin_translations', 'page'),
    'dbField' => 'id',
    'showOnList' => true,
    'searchable' => true,
    'defaultValue' => true,
    'disabledOnUpdate' => true, 
    'order' => true 
    )
    );
    $this->addElement($element);    
    
    
    
    $element = new \Modules\developer\std_mod\ElementBool(
    array(
    'title' => $parametersMod->getValue('community', 'comments', 'admin_translations', 'approved'),
    'dbField' => 'approved',
    'showOnList' => true,
    'searchable' => true,
    'defaultValue' => true 
    )
    );
    $this->addElement($element);
        
    
    $element = new \Modules\developer\std_mod\ElementDateTime(
    array(     
    'title' => $parametersMod->getValue('community', 'comments', 'admin_translations', 'created'),
    'dbField' => 'created',
    'showOnList' => true,
    'searchable' => true,
    'defaultValue' => date('Y-m-d H:i:s'),
    'visibleOnInsert' => false, 
    'order' => true
    )
    );
    $this->addElement($element);        

    
    
  }
  

  
  public function afterUpdate($recordId){
    global $site;
    require_once(__DIR__.'/db.php');
    $comment = Db::getComment($recordId);    
    if(!$this->beforeUpdateApproved && $comment['approved']){
      $site->dispatchEvent('community', 'comments', 'comment_approved', array('id'=>$recordId));
    }
    
    if($this->beforeUpdateApproved && !$comment['approved']){
      $site->dispatchEvent('community', 'comments', 'comment_disapproved', array('id'=>$recordId));
    }
    
  }
  

  public function beforeUpdate($recordId){
    require_once(__DIR__.'/db.php');
    $comment = Db::getComment($recordId);
    $this->beforeUpdateApproved = $comment['approved'];  
  }
  

  public function afterDelete($recordId){
    global $site;
    $site->dispatchEvent('community', 'comments', 'comment_deleted', array('id'=>$recordId)); 
  }
 
}