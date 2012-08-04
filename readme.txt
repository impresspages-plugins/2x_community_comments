COMMENTS

ImpressPages CMS plugin


INSTALL

1. Upload folder "community" to "ip_plugins" directory of your website.
2. Login to administration area
3. Go to "Developer -> Modules" and press "install".
4. Place comments and comment form anywhere in your template:

<?php

require_once(BASE_DIR.PLUGIN_DIR.'community/comments/module.php');
$comments = new \Modules\community\comments\Module();
echo $comments->generateComments();
echo $comments->generateForm();

?>


The system will detect current page and print appropriate comments and form.