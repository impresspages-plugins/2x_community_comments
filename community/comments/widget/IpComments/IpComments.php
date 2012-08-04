<?php
/**
 * @package   ImpressPages
 * @copyright Copyright (C) 2012 JSC Apro Media.
 * @license   GNU/GPL, see ip_license.html
 */

namespace Modules\community\comments\widget;

class IpComments extends \Modules\standard\content_management\Widget
{

    public function getTitle()
    {
        global $parametersMod;
        return $parametersMod->getValue('community', 'comments', 'admin_translations', 'comments');
    }

    public function managementHtml($instanceId, $data, $layout)
    {
        return parent::managementHtml($instanceId, $data, $layout);
    }

    public function previewHtml($instanceId, $data, $layout)
    {
        global $parametersMod;
        global $session;

        if ($parametersMod->getValue('community', 'comments', 'options', 'require_login') && !$session->loggedIn()) {
            return \Ip\View::create('view/login.php')->render();
        }

        $model = new \Modules\community\comments\Model();
        $service = new \Modules\community\comments\Service();
        $data['form'] = $model->createForm();
        $comments = $service->getComments();
        foreach ($comments as &$comment) {
            $comment['text'] = str_replace("\n", "<br/>", htmlspecialchars($comment['text']));
        }
        $data['comments'] = $comments;

        return parent::previewHtml($instanceId, $data, $layout);
    }





}
