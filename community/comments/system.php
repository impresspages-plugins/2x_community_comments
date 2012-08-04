<?php
/**
 * @package   ImpressPages
 * @copyright Copyright (C) 2012 JSC Apro Media.
 * @license   GNU/GPL, see ip_license.html
 */

namespace Modules\community\comments;


class System{



    function init(){
        global $site;
        global $dispatcher;

        $dispatcher->bind('site.generateBlock', __NAMESPACE__ .'\System::generateComments');
    }

    public static function generateComments (\Ip\Event $event) {
        global $site;
        $blockName = $event->getValue('blockName');
        if ($blockName == 'ipComments') {
            $commentsBox = \Ip\View::create('view/comments.php');
            $event->setValue('content', $commentsBox );
            $event->addProcessed();
        }
    }



}