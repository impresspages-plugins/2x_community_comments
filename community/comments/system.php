<?php
/**
 * @package   ImpressPages
 * @copyright Copyright (C) 2012 JSC Apro Media.
 * @license   GNU/GPL, see ip_license.html
 */

namespace Modules\community\comments;


class System{

    function init(){
        global $dispatcher;
        global $site;

        $site->addCSS(BASE_URL.PLUGIN_DIR.'community/comments/public/comments.css');

        $site->addJavascript(BASE_URL.LIBRARY_DIR.'js/jquery/jquery.js');
        $site->addJavascript(BASE_URL.LIBRARY_DIR.'js/jquery-tools/jquery.tools.form.js');
        $site->addJavascript(BASE_URL.MODULE_DIR.'standard/content_management/public/widgets.js');

        $site->addJavascript($site->generateUrl(null, null, array('tinymceConfig.js')));
        $site->addJavascript($site->generateUrl(null, null, array('validatorConfig.js')));

        $site->addJavascript(BASE_URL.PLUGIN_DIR.'community/comments/public/ipComments.js');



        $dispatcher->bind('site.generateBlock', __NAMESPACE__ .'\System::generateComments');
    }

    public static function generateComments (\Ip\Event $event) {
        $blockName = $event->getValue('blockName');
        if ($blockName == 'ipComments') {
            $commentsBox = \Ip\View::create('view/comments.php');
            $event->setValue('content', $commentsBox );
            $event->addProcessed();
        }
    }



}