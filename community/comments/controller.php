<?php
/**
 * @package   ImpressPages
 * @copyright Copyright (C) 2012 JSC Apro Media.
 * @license   GNU/GPL, see ip_license.html
 */

namespace Modules\community\comments;



class Controller extends \Ip\Controller
{


    public function post()
    {
        global $parametersMod;
        global $site;
        global $dispatcher;
        global $session;

        $model = new Model();
        $form = $model->createForm();
        $errors = $form->validate($_POST);

        $in5Min = Db::commentsLastMinutes(5, $_SERVER['REMOTE_ADDR']);
        $in60Min = Db::commentsLastMinutes(60, $_SERVER['REMOTE_ADDR']);
        $limit5 = $parametersMod->getValue('community', 'comments', 'options', 'limit_in_5_min');
        $limit60 = $parametersMod->getValue('community', 'comments', 'options', 'limit_in_60_min');
        if ($limit5 != 0 && sizeof($in5Min) >= $limit5 || $limit60 != 0 && sizeof($in60Min) >= $limit60) {
            $errors['globalError'] = $parametersMod->getValue('community', 'comments', 'translations', 'error_comments_limit');
        }

        if ($errors) {
            //return error
            $data = array(
                'status' => 'error',
                'errors' => $errors
            );
        } else {
            //save, send email return success
            $verifiedData = $form->filterValues($_POST);

            require_once(BASE_DIR . LIBRARY_DIR . 'php/text/system_variables.php');
            require_once(BASE_DIR . LIBRARY_DIR . 'php/text/html_transform.php');

            if ($session->userId() !== false) {
                $userId = $session->userId();
            } else {
                $userId = null;
            }

            $_SESSION['modules']['community']['comments']['last_name'] = $verifiedData['name'];
            $_SESSION['modules']['community']['comments']['last_email'] = $verifiedData['email'];
            $_SESSION['modules']['community']['comments']['last_link'] = $verifiedData['link'];


            if ($verifiedData['link'] !== '' and strpos($verifiedData['link'], 'https://') !== 0 and strpos($verifiedData['link'], 'http://') !== 0) {
                $verifiedData['link'] = 'http://' . $verifiedData['link'];
            }


            $verificationCode = md5(uniqid(rand(), true));

            $approved = !$parametersMod->getValue('community', 'comments', 'options', 'require_admin_confirmation');

            $commentId = Db::insertComment(
                $languageId = $verifiedData['language_id'],
                $zoneName = $verifiedData['zone_name'],
                $pageId = $verifiedData['page_id'],
                $userId = $userId,
                $name = $verifiedData['name'],
                $email = $verifiedData['email'],
                $link = $verifiedData['link'],
                $text = $verifiedData['text'],
                $ip = $_SERVER['REMOTE_ADDR'],
                $sessionId = session_id(),
                $verificationCode = $verificationCode,
                $approved = $approved
            );

            $dispatcher->notify(new \Ip\Event($site, 'comments.new', array('id' => $commentId, 'postData' => $verifiedData)));

            if ($parametersMod->getValue('community', 'comments', 'options', 'inform_about_new_comments')) {
                $this->sendConfirmationEmail($_POST, $commentId, $verificationCode);
            }

            if ($approved) {
                $dispatcher->notify(new \Ip\Event($site, 'comments.approved', array('id' => $commentId)));
            }

            $commentUrl = $site->getCurrentUrl();
            if (strpos($commentUrl, '?') === false) {
                $commentUrl .= '?';
            } else {
                $commentUrl .= '&';
            }
            $commentUrl .= '#ipComment-'.$commentId;

            $data = array(
                'status' => 'success',
                'redirectUrl' => $commentUrl
            );
        }

        $this->returnJson($data);
    }



    private function sendConfirmationEmail($postData, $commentId, $verificationCode)
    {
        global $site;
        global $parametersMod;
        require_once (BASE_DIR . MODULE_DIR . 'administrator/email_queue/module.php');

        $zone = $site->getZone($postData['zone_name']);
        if ($zone) {
            $element = $zone->getElement($postData['page_id']);
            if ($element) {
                $link = $element->getLink();
            } else {
                $link = $site->generateUrl();
            }
        } else {
            $link = $site->generateUrl();
        }

        $approveLink = $link;
        if (strpos($approveLink, '?') === false) {
            $approveLink = $approveLink . '?g=community&m=comments&a=approveComment&id=' . $commentId . '&code=' . $verificationCode . '#ipComment-' . $commentId;
        } else {
            $approveLink = $approveLink . '&g=community&m=comments&a=approveComment&id=' . $commentId . '&code=' . $verificationCode . '#ipComment-' . $commentId;
        }

        $hideLink = $link;
        if (strpos($hideLink, '?') === false) {
            $hideLink = $hideLink . '?g=community&m=comments&a=hideComment&id=' . $commentId . '&code=' . $verificationCode;
        } else {
            $hideLink = $hideLink . '&g=community&m=comments&a=hideComment&id=' . $commentId . '&code=' . $verificationCode;
        }

        if ($parametersMod->getValue('community', 'comments', 'options', 'require_admin_confirmation')) {
            $emailHtml = $parametersMod->getValue('community', 'comments', 'email_translations', 'new_comment_text_approve');
        } else {
            $emailHtml = $parametersMod->getValue('community', 'comments', 'email_translations', 'new_comment_text_hide');
        }
        $emailHtml = str_replace('[[link]]', '<a href="' . $link . '">' . \Library\Php\Text\HtmlTransform::prepareLink($link) . '</a>', $emailHtml);
        $emailHtml = str_replace('[[approve_link]]', '<a href="' . $approveLink . '">' . \Library\Php\Text\HtmlTransform::prepareLink($approveLink) . '</a>', $emailHtml);
        $emailHtml = str_replace('[[hide_link]]', '<a href="' . $hideLink . '">' . \Library\Php\Text\HtmlTransform::prepareLink($hideLink) . '</a>', $emailHtml);

        $comment = '';
        $comment .= '<strong>' . htmlspecialchars($parametersMod->getValue('community', 'comments', 'translations', 'name')) . ':</strong> ' . $postData['name'] . '<br/>';
        $comment .= '<strong>' . htmlspecialchars($parametersMod->getValue('community', 'comments', 'translations', 'email')) . ':</strong> <a href="mailto:' . $postData['email'] . '">' . $postData['email'] . '</a><br/>';
        $comment .= '<strong>' . htmlspecialchars($parametersMod->getValue('community', 'comments', 'translations', 'link')) . ':</strong> <a href="' . $postData['link'] . '">' . $postData['link'] . '</a><br/>';
        $comment .= '<strong>' . htmlspecialchars($parametersMod->getValue('community', 'comments', 'translations', 'text')) . ':</strong> <br/>' . str_replace("\n", "<br/>", htmlspecialchars($postData['text']));

        $emailHtml = str_replace('[[comment]]', $comment, $emailHtml);


        $emailHtml = str_replace('[[content]]', $emailHtml, $parametersMod->getValue('standard', 'configuration', 'main_parameters', 'email_template'));
        $emailHtml = \Library\Php\Text\SystemVariables::insert($emailHtml);
        $emailHtml = \Library\Php\Text\SystemVariables::clear($emailHtml);


        $emailQueue = new \Modules\administrator\email_queue\Module();

        if ($parametersMod->getValue('community', 'comments', 'options', 'use_separate_email') != '') {
            $toEmail = $parametersMod->getValue('community', 'comments', 'options', 'use_separate_email');
        } else {
            $toEmail = $parametersMod->getValue('standard', 'configuration', 'main_parameters', 'email');
        }

        $email = $_POST['email'];

        $name = $_POST['name'];

        $emailQueue->addEmail(
            $email,
            $name,
            $toEmail,
            '',
            $parametersMod->getValue('community', 'comments', 'email_translations', 'new_comment_subject'),
            $emailHtml,
            true, true, null);
        $emailQueue->send();
    }



    public function approveComment()
    {
        global $site;
        if (isset($_REQUEST['id']) && isset($_REQUEST['code'])) {
            $affectedRows = Db::approveComment($_REQUEST['id'], $_REQUEST['code']);
            if ($affectedRows) {
                $site->dispatchEvent('community', 'comments', 'comment_approved', array('id' => $_REQUEST['id']));
            }
        }
    }

    public function hideComment()
    {
        global $site;
        if (isset($_REQUEST['id']) && isset($_REQUEST['code'])) {
            $affectedRows = Db::hideComment($_REQUEST['id'], $_REQUEST['code']);
            if ($affectedRows) {
                $site->dispatchEvent('community', 'comments', 'comment_disapproved', array('id' => $_REQUEST['id']));
            }
        }
    }




}


 
