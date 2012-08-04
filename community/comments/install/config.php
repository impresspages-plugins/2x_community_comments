<?php
//language description
$languageCode = "en"; //RFC 4646 code
$languageShort = "EN"; //Short description
$languageLong = "English"; //Long title
$languageUrl = "en";


$moduleGroupTitle["community"] = "Community";
$moduleTitle["community"]["comments"] = "Comments";
  
  $parameterGroupTitle["community"]["comments"]["admin_translations"] = "Administrator translations";
  $parameterGroupAdmin["community"]["comments"]["admin_translations"] = "1";

    $parameterTitle["community"]["comments"]["admin_translations"]["comments"] = "Comments";
    $parameterValue["community"]["comments"]["admin_translations"]["comments"] = "Comments";
    $parameterAdmin["community"]["comments"]["admin_translations"]["comments"] = "0";
    $parameterType["community"]["comments"]["admin_translations"]["comments"] = "string";

    $parameterTitle["community"]["comments"]["admin_translations"]["id"] = "Id";
    $parameterValue["community"]["comments"]["admin_translations"]["id"] = "Id";
    $parameterAdmin["community"]["comments"]["admin_translations"]["id"] = "1";
    $parameterType["community"]["comments"]["admin_translations"]["id"] = "string";

    $parameterTitle["community"]["comments"]["admin_translations"]["approved"] = "Approved";
    $parameterValue["community"]["comments"]["admin_translations"]["approved"] = "Approved";
    $parameterAdmin["community"]["comments"]["admin_translations"]["approved"] = "1";
    $parameterType["community"]["comments"]["admin_translations"]["approved"] = "string";

    $parameterTitle["community"]["comments"]["admin_translations"]["modified"] = "Modified";
    $parameterValue["community"]["comments"]["admin_translations"]["modified"] = "Modified";
    $parameterAdmin["community"]["comments"]["admin_translations"]["modified"] = "1";
    $parameterType["community"]["comments"]["admin_translations"]["modified"] = "string";

    $parameterTitle["community"]["comments"]["admin_translations"]["created"] = "Created";
    $parameterValue["community"]["comments"]["admin_translations"]["created"] = "Created";
    $parameterAdmin["community"]["comments"]["admin_translations"]["created"] = "1";
    $parameterType["community"]["comments"]["admin_translations"]["created"] = "string";

    $parameterTitle["community"]["comments"]["admin_translations"]["ip"] = "IP";
    $parameterValue["community"]["comments"]["admin_translations"]["ip"] = "IP";
    $parameterAdmin["community"]["comments"]["admin_translations"]["ip"] = "1";
    $parameterType["community"]["comments"]["admin_translations"]["ip"] = "string";

    $parameterTitle["community"]["comments"]["admin_translations"]["link"] = "Link";
    $parameterValue["community"]["comments"]["admin_translations"]["link"] = "Link";
    $parameterAdmin["community"]["comments"]["admin_translations"]["link"] = "1";
    $parameterType["community"]["comments"]["admin_translations"]["link"] = "string";

    $parameterTitle["community"]["comments"]["admin_translations"]["email"] = "Email";
    $parameterValue["community"]["comments"]["admin_translations"]["email"] = "Email";
    $parameterAdmin["community"]["comments"]["admin_translations"]["email"] = "1";
    $parameterType["community"]["comments"]["admin_translations"]["email"] = "string";

    $parameterTitle["community"]["comments"]["admin_translations"]["name"] = "Name";
    $parameterValue["community"]["comments"]["admin_translations"]["name"] = "Name";
    $parameterAdmin["community"]["comments"]["admin_translations"]["name"] = "1";
    $parameterType["community"]["comments"]["admin_translations"]["name"] = "string";

    $parameterTitle["community"]["comments"]["admin_translations"]["comment"] = "Comment";
    $parameterValue["community"]["comments"]["admin_translations"]["comment"] = "Comment";
    $parameterAdmin["community"]["comments"]["admin_translations"]["comment"] = "1";
    $parameterType["community"]["comments"]["admin_translations"]["comment"] = "string";

    $parameterTitle["community"]["comments"]["admin_translations"]["page"] = "Page";
    $parameterValue["community"]["comments"]["admin_translations"]["page"] = "Page";
    $parameterAdmin["community"]["comments"]["admin_translations"]["page"] = "1";
    $parameterType["community"]["comments"]["admin_translations"]["page"] = "string";
  
  $parameterGroupTitle["community"]["comments"]["email_translations"] = "Email translations";
  $parameterGroupAdmin["community"]["comments"]["email_translations"] = "1";

    $parameterTitle["community"]["comments"]["email_translations"]["new_comment_text_hide"] = "New comment text hide";
    $parameterValue["community"]["comments"]["email_translations"]["new_comment_text_hide"] = "<p>There is a new comment on your website [[link]]</p>
<p>[[comment]]</p>
<p>Press this link to hide it:</p>
<p>[[hide_link]]</p>";
    $parameterAdmin["community"]["comments"]["email_translations"]["new_comment_text_hide"] = "1";
    $parameterType["community"]["comments"]["email_translations"]["new_comment_text_hide"] = "string_wysiwyg";

    $parameterTitle["community"]["comments"]["email_translations"]["new_comment_text_approve"] = "New comment text approve";
    $parameterValue["community"]["comments"]["email_translations"]["new_comment_text_approve"] = "<p>There is a new comment on your website [[link]]</p>
<p>[[comment]]</p>
<p>Press this link to approve it:</p>
<p>[[approve_link]]</p>";
    $parameterAdmin["community"]["comments"]["email_translations"]["new_comment_text_approve"] = "1";
    $parameterType["community"]["comments"]["email_translations"]["new_comment_text_approve"] = "string_wysiwyg";

    $parameterTitle["community"]["comments"]["email_translations"]["new_comment_subject"] = "New comment subject";
    $parameterValue["community"]["comments"]["email_translations"]["new_comment_subject"] = "New comment";
    $parameterAdmin["community"]["comments"]["email_translations"]["new_comment_subject"] = "1";
    $parameterType["community"]["comments"]["email_translations"]["new_comment_subject"] = "string";
  
  $parameterGroupTitle["community"]["comments"]["options"] = "Options";
  $parameterGroupAdmin["community"]["comments"]["options"] = "0";

    $parameterTitle["community"]["comments"]["options"]["use_separate_email"] = "Use separate email";
    $parameterValue["community"]["comments"]["options"]["use_separate_email"] = "";
    $parameterAdmin["community"]["comments"]["options"]["use_separate_email"] = "0";
    $parameterType["community"]["comments"]["options"]["use_separate_email"] = "string";

    $parameterTitle["community"]["comments"]["options"]["limit_in_5_min"] = "Limit in 5 min.";
    $parameterValue["community"]["comments"]["options"]["limit_in_5_min"] = "3";
    $parameterAdmin["community"]["comments"]["options"]["limit_in_5_min"] = "0";
    $parameterType["community"]["comments"]["options"]["limit_in_5_min"] = "integer";

    $parameterTitle["community"]["comments"]["options"]["limit_in_60_min"] = "Limit in 60 min";
    $parameterValue["community"]["comments"]["options"]["limit_in_60_min"] = "10";
    $parameterAdmin["community"]["comments"]["options"]["limit_in_60_min"] = "0";
    $parameterType["community"]["comments"]["options"]["limit_in_60_min"] = "integer";

    $parameterTitle["community"]["comments"]["options"]["require_admin_confirmation"] = "Require admin confirmation";
    $parameterValue["community"]["comments"]["options"]["require_admin_confirmation"] = "1";
    $parameterAdmin["community"]["comments"]["options"]["require_admin_confirmation"] = "0";
    $parameterType["community"]["comments"]["options"]["require_admin_confirmation"] = "bool";

    $parameterTitle["community"]["comments"]["options"]["inform_about_new_comments"] = "Inform about new comments";
    $parameterValue["community"]["comments"]["options"]["inform_about_new_comments"] = "1";
    $parameterAdmin["community"]["comments"]["options"]["inform_about_new_comments"] = "0";
    $parameterType["community"]["comments"]["options"]["inform_about_new_comments"] = "bool";

    $parameterTitle["community"]["comments"]["options"]["use_captcha"] = "Use captcha";
    $parameterValue["community"]["comments"]["options"]["use_captcha"] = "0";
    $parameterAdmin["community"]["comments"]["options"]["use_captcha"] = "0";
    $parameterType["community"]["comments"]["options"]["use_captcha"] = "bool";
  
  $parameterGroupTitle["community"]["comments"]["translations"] = "Translations";
  $parameterGroupAdmin["community"]["comments"]["translations"] = "0";

    $parameterTitle["community"]["comments"]["translations"]["comments"] = "Comments";
    $parameterValue["community"]["comments"]["translations"]["comments"] = "Comments";
    $parameterAdmin["community"]["comments"]["translations"]["comments"] = "0";
    $parameterType["community"]["comments"]["translations"]["comments"] = "lang";

    $parameterTitle["community"]["comments"]["translations"]["comment"] = "Comment";
    $parameterValue["community"]["comments"]["translations"]["comment"] = "Write a comment";
    $parameterAdmin["community"]["comments"]["translations"]["comment"] = "0";
    $parameterType["community"]["comments"]["translations"]["comment"] = "lang";

    $parameterTitle["community"]["comments"]["translations"]["send"] = "Send";
    $parameterValue["community"]["comments"]["translations"]["send"] = "Send";
    $parameterAdmin["community"]["comments"]["translations"]["send"] = "0";
    $parameterType["community"]["comments"]["translations"]["send"] = "lang";

    $parameterTitle["community"]["comments"]["translations"]["name"] = "Name";
    $parameterValue["community"]["comments"]["translations"]["name"] = "Name";
    $parameterAdmin["community"]["comments"]["translations"]["name"] = "0";
    $parameterType["community"]["comments"]["translations"]["name"] = "lang";

    $parameterTitle["community"]["comments"]["translations"]["email"] = "Email";
    $parameterValue["community"]["comments"]["translations"]["email"] = "Email";
    $parameterAdmin["community"]["comments"]["translations"]["email"] = "0";
    $parameterType["community"]["comments"]["translations"]["email"] = "lang";

    $parameterTitle["community"]["comments"]["translations"]["link"] = "Link";
    $parameterValue["community"]["comments"]["translations"]["link"] = "Link";
    $parameterAdmin["community"]["comments"]["translations"]["link"] = "0";
    $parameterType["community"]["comments"]["translations"]["link"] = "lang";

    $parameterTitle["community"]["comments"]["translations"]["text"] = "Text";
    $parameterValue["community"]["comments"]["translations"]["text"] = "Text";
    $parameterAdmin["community"]["comments"]["translations"]["text"] = "0";
    $parameterType["community"]["comments"]["translations"]["text"] = "lang";

    $parameterTitle["community"]["comments"]["translations"]["says"] = "Says";
    $parameterValue["community"]["comments"]["translations"]["says"] = "Says:";
    $parameterAdmin["community"]["comments"]["translations"]["says"] = "0";
    $parameterType["community"]["comments"]["translations"]["says"] = "lang";

    $parameterTitle["community"]["comments"]["translations"]["email_note"] = "Email note";
    $parameterValue["community"]["comments"]["translations"]["email_note"] = "(will not be published)";
    $parameterAdmin["community"]["comments"]["translations"]["email_note"] = "0";
    $parameterType["community"]["comments"]["translations"]["email_note"] = "lang";

    $parameterTitle["community"]["comments"]["translations"]["awaiting_moderation"] = "Awaiting moderation";
    $parameterValue["community"]["comments"]["translations"]["awaiting_moderation"] = "Your comment is awaiting moderation.  ";
    $parameterAdmin["community"]["comments"]["translations"]["awaiting_moderation"] = "0";
    $parameterType["community"]["comments"]["translations"]["awaiting_moderation"] = "lang";

    $parameterTitle["community"]["comments"]["translations"]["captcha"] = "Captcha";
    $parameterValue["community"]["comments"]["translations"]["captcha"] = "Enter the symbols shown in the image";
    $parameterAdmin["community"]["comments"]["translations"]["captcha"] = "0";
    $parameterType["community"]["comments"]["translations"]["captcha"] = "lang";

    $parameterTitle["community"]["comments"]["translations"]["error_comments_limit"] = "Error comments limit reached";
    $parameterValue["community"]["comments"]["translations"]["error_comments_limit"] = "Too many comments. Please wait a few minutes.";
    $parameterAdmin["community"]["comments"]["translations"]["error_comments_limit"] = "0";
    $parameterType["community"]["comments"]["translations"]["error_comments_limit"] = "lang";