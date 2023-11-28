<?php

$title = $data['name'];

$components = isset($data['components']) ? implode(', ', $data['components']) :  'none';

$successMessage = $data['successMessage'] ?? null;
$errorMessage = $data['errorMessage'] ?? null;

ob_start(); ?>
<div>
    <h1><?= $title ?></h1>
    <div class="container">
        <div class="description"><span><strong>Description: </strong> </span><?= $data['description'] ?></div>
        <div class="components-list">
            <span><strong>Components: </strong> </span><span><?= $components ?></span>
        </div>
        <a class="btn btn-danger" href="/delete?id=<?= $data['id'] ?>" role="button">Delete perfume</a>
    </div>
</div>
<?php $content = ob_get_clean();

require_once VIEWS_DIR . 'layout.php';
