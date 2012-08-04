<?php
/**
 * @package   ImpressPages
 * @copyright Copyright (C) 2012 JSC Apro Media.
 * @license   GNU/GPL, see ip_license.html
 */

namespace Modules\community\comments;


class Model
{


    /**
     * @return \Modules\developer\form\Form
     */
    public function createForm()
    {
        global $site;
        global $session;
        global $parametersMod;


        require_once(BASE_DIR . MODULE_DIR . 'community/user/db.php');
        $id = $session->userId();
        $userData = \Modules\community\user\Db::userById($id);


        $form = new \Modules\developer\form\Form();


        $field = new \Modules\developer\form\Field\Blank(
            array(
                'name' => 'globalError'
            ));
        $form->addField($field);

        $options = array(
            'label' => $parametersMod->getValue('community', 'comments', 'translations', 'name'),
            'name' => 'name',
            'dbName' => 'name',
            'defaultValue' => ''
        );
        if (isset($_SESSION['modules']['community']['comments']['last_name'])) {
            $options['defaultValue'] = $_SESSION['modules']['community']['comments']['last_name'];
        }
        if ($session->loggedIn() && $userData['name'] != '') {
            $options['defaultValue'] = $userData['name'];
        }
        $field = new \Modules\developer\form\Field\Text($options);
        $field->addValidator('Required');
        $form->addField($field);


        $options = array(
            'label' => $parametersMod->getValue('community', 'comments', 'translations', 'email'),
            'name' => 'email',
            'dbName' => 'email',
            'defaultValue' => ''
        );
        if (isset($_SESSION['modules']['community']['comments']['last_email'])) {
            $options['defaultValue'] = $_SESSION['modules']['community']['comments']['last_email'];
        }
        if ($session->loggedIn() && $userData['email'] != '') {
            $options['defaultValue'] = $userData['email'];
        }
        $field = new \Modules\developer\form\Field\Email($options);
        $field->addValidator('Required');
        $form->addField($field);


        $options = array(
            'label' => $parametersMod->getValue('community', 'comments', 'translations', 'link'),
            'name' => 'link',
            'dbName' => 'link',
            'defaultValue' => ''
        );
        if (isset($_SESSION['modules']['community']['comments']['last_link'])) {
            $options['defaultValue'] = $_SESSION['modules']['community']['comments']['last_link'];
        }
        $field = new \Modules\developer\form\Field\Text($options);
        $form->addField($field);


        if ($parametersMod->getValue('community', 'comments', 'options', 'use_captcha')) {
            $options = array(
                'label' => $parametersMod->getValue('community', 'comments', 'translations', 'captcha'),
                'name' => 'captcha',
                'required' => true
            );
            $field = new \Modules\developer\form\Field\Captcha($options);
            $form->addField($field);
        }


        $options = array(
            'label' => $parametersMod->getValue('community', 'comments', 'translations', 'text'),
            'name' => 'text',
            'dbName' => 'text',
            'defaultValue' => ''
        );
        $field = new \Modules\developer\form\Field\Textarea($options);
        $field->addValidator('Required');
        $form->addField($field);


        //hidden fields to define page
        $field = new \Modules\developer\form\Field\Hidden(
            array(
                'name' => 'language_id',
                'defaultValue' => $site->getCurrentLanguage()->getId()
            ));
        $form->addField($field);

        $field = new \Modules\developer\form\Field\Hidden(
            array(
                'name' => 'zone_name',
                'defaultValue' => $site->getCurrentZoneName()
            ));
        $form->addField($field);

        $field = new \Modules\developer\form\Field\Hidden(
            array(
                'name' => 'page_id',
                'defaultValue' => $site->getCurrentElement()->getId()
            ));
        $form->addField($field);


        //special variables to post to plugin controller
        $field = new \Modules\developer\form\Field\Hidden(
            array(
                'name' => 'g',
                'defaultValue' => 'community'
            ));
        $form->addField($field);

        $field = new \Modules\developer\form\Field\Hidden(
            array(
                'name' => 'm',
                'defaultValue' => 'comments'
            ));
        $form->addField($field);

        $field = new \Modules\developer\form\Field\Hidden(
            array(
                'name' => 'a',
                'defaultValue' => 'post'
            ));
        $form->addField($field);

        //antispam
        $field = new \Modules\developer\form\Field\Check(
            array(
                'name' => 'checkField'
            ));
        $form->addField($field);

        //submit
        $field = new \Modules\developer\form\Field\Submit(
            array(
                'defaultValue' => $parametersMod->getValue('community', 'comments', 'translations', 'send')
            ));
        $form->addField($field);


        return $form;
    }


}