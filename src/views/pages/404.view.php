<?php

$title = 'Page not found';

ob_start(); ?>
<h1>Page not found</h1>
<a href="<?= SITE_URL ?>">Back to homepage</a>
<?php $content = ob_get_clean();

require_once VIEWS_DIR . 'layout.php';
