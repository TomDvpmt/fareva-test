<?php

$title = 'Add a perfume';

ob_start(); ?>
<h1><?= $title ?></h1>
<form method="POST">
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" aria-describedby="emailHelp">
        <div id="nameHelp" class="form-text">Max. 100 characters</div>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <input type="text" class="form-control" id="description">
        <div id="descriptionHelp" class="form-text">Max. 500 characters</div>
    </div>
    <!-- <div class="mb-3">
        <label class="form-label">Components</label>
        <div class="input-group">
            <input type="checkbox" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1">TODO COMPONENTS</label>
        </div>
    </div> -->

    <button type="submit" class="btn btn-primary">Add</button>
</form>
<?php $content = ob_get_clean();

require_once VIEWS_DIR . 'layout.php';
