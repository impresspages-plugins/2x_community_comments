<?php
/**
 * @package   ImpressPages
 * @copyright Copyright (C) 2012 JSC Apro Media.
 * @license   GNU/GPL, see ip_license.html
 */

namespace Modules\community\comments;


require_once(BASE_DIR.PLUGIN_DIR.'community/comments/comments_area.php');
require_once(BASE_DIR.MODULE_DIR.'developer/std_mod/std_mod.php');


class Manager{
  var $standardModule;
   


  function __construct() {
    global $parametersMod;

    $commentsArea = new CommentsArea();
     
    $this->standardModule = new \Modules\developer\std_mod\StandardModule($commentsArea);
  }

  
  
  function manage() {
    return $this->standardModule->manage();
  }
}
