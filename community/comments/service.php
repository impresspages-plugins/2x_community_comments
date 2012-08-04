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

    public function getCommentById($id)
    {
        return Db::getComment($id);
    }

    public function getComments($languageId = null, $zoneName = null, $pageId = null)
    {
        global $site;

        if($languageId === null){
            $languageId = $site->getCurrentLanguage()->getId();
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



}