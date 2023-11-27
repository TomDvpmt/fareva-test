<?php

$title = 'Add a perfume';
$name = $data['name'] ?? null;
$description = $data['description'] ?? null;
$successMessage = $data['successMessage'] ?? null;
$errorMessage = $data['errorMessage'] ?? null;

ob_start(); ?>
<h1><?= $title ?></h1>
<?php echo $successMessage ? '<p class="alert alert-success">' . $successMessage . '</p>' : null ?>
<?php echo $errorMessage ? '<p class="alert alert-danger">' . $errorMessage . '</p>' : null ?>
<form method="POST">
    <div class="mb-3">
        <label class="form-label">Gender</label>
        <div class="input-group">
            <select class="form-select" aria-label="Gender select" name="gender" id="gender">
                <option value="0">All</option>
                <option value="1">Men</option>
                <option value="2">Women</option>
            </select>
        </div>
    </div>
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp" value="<?= $name ?>">
        <div id="nameHelp" class="form-text">Max. 100 characters</div>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <input type="text" class="form-control" id="description" name="description" value="<?= $description ?>">
        <div id="descriptionHelp" class="form-text">Max. 500 characters</div>
    </div>
    <div class="mb-3">
        <label class="form-label">Components</label>
        <div class="input-group">
            <input type="checkbox" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1">TODO COMPONENTS</label>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Add</button>
</form>
<?php $content = ob_get_clean();

require_once VIEWS_DIR . 'layout.php';
