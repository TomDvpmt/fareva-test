<?php

$title = 'Our perfumes';

ob_start(); ?>

<h1><?= $title ?></h1>
<p>list</p>

<?php $content = ob_get_clean();

require_once VIEWS_DIR . 'layout.php';
