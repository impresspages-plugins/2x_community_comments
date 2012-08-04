COMMENTS

ImpressPages CMS plugin


INSTALL

1. Upload folder "community" to "ip_plugins" directory of your website.
2. Login to administration area
3. Go to "Developer -> Modules" and press "install".
4. Place comments and comment form anywhere in your template (eg. ip_themes/lt_pagan/main.php):

<?php echo $site->generateBlock('ipComments') ?>

The system will detect current page and print appropriate comments and form.

Alternatively you can add comments on chosen page using comments widget. Keep in mind that there is
no sense to put two comments block on one page because they both will output the same comments.