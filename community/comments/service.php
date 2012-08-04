<?php
/**
 * @package   ImpressPages
 * @copyright Copyright (C) 2012 JSC Apro Media.
 * @license   GNU/GPL, see ip_license.html
 */

namespace Modules\community\comments;


/**
 *
 * Use this class when trying to get data from within your own plugin.
 *
 */
class Service
{

    public function getComments($languageId = null, $zoneName = null, $pageId = null)
    {
        global $site;

        if($languageId === null){
            $languageId = $site->currentLanguage['id'];
        }

        if($zoneName === null){
            $zoneName = $site->getCurrentZoneName();
        }

        if($pageId === null){
            $pageId = $site->getCurrentElement()->getId();
        }

        $allComments = Db::getComments($languageId, $zoneName, $pageId);

        $comments = array();

        foreach ($allComments as $comment){
            if($comment['approved'] || $comment['session_id'] == session_id()){
                $comments[] = $comment;
            }
        }

        return $comments;
    }


    public function generateForm($languageId = null, $zoneName = null, $pageId = null)
    {
        global $site;

        $site->requireConfig('community/comments/config.php');
        $site->requireTemplate('community/comments/template.php');
        require_once(BASE_DIR.LIBRARY_DIR.'php/form/standard.php');

        $answer = '';

        if($languageId === null){
            $languageId = $site->currentLanguage['id'];
        }

        if($zoneName === null){
            $zoneName = $site->getCurrentZoneName();
        }

        if($pageId === null){
            $pageId = $site->getCurrentElement()->getId();
        }


        $fields = Config::getFields();

        $field =  new \Library\Php\Form\FieldHidden();
        $field->name = 'module_group';
        $field->value = 'community';
        $fields[] = $field;

        $field =  new \Library\Php\Form\FieldHidden();
        $field->name = 'module_name';
        $field->value = 'comments';
        $fields[] = $field;

        $field =  new \Library\Php\Form\FieldHidden();
        $field->name = 'action';
        $field->value = 'comment';
        $fields[] = $field;


        $field =  new \Library\Php\Form\FieldHidden();
        $field->name = 'language_id';
        $field->value = $site->currentLanguage['id'];
        $fields[] = $field;

        $field =  new \Library\Php\Form\FieldHidden();
        $field->name = 'zone_name';
        $field->value = $site->getCurrentZoneName();
        $fields[] = $field;

        $field =  new \Library\Php\Form\FieldHidden();
        $field->name = 'page_id';
        $field->value = $site->getCurrentElement()->getId();
        $fields[] = $field;

        $answer = Template::generateForm($fields);

        return $answer;
    }


}