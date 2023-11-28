<?php

$title = 'Our perfumes';
$successMessage = $data['successMessage'] ?? null;
$errorMessage = $data['errorMessage'] ?? null;

/* Filters */

$componentCheckboxes = [];

foreach ($data['allComponents'] as $component) {
    $checked = isset($_GET[$component['name']]) ? 'checked' : null;
    $checkbox = '
        <div class="component-checkbox">
            <input type="checkbox" class="form-check-input" id="' . $component['id'] . '" name="' . $component['name'] . '" ' . $checked . '>
            <label class="form-check-label" for="exampleCheck1">' . $component['name'] . '</label>
        </div>
    ';
    array_push($componentCheckboxes, $checkbox);
}

/* Rows */

$rows = [];

foreach ($data['perfumes'] as $perfume) {
    $components = implode(', ', $perfume['components']);
    $gender = $perfume['gender'] === 1 ? 'men' : 'women';
    $row = '
        <tr id="' . $perfume['id'] . '" class="perfume-row">
                <td id="name">' . $perfume['name'] .  '</td>
                <td id="gender">' . $gender . '</td>
                <td id="description">' . $perfume['description'] . '</td>
                <td id="components">' . $components . '</td>
                <td><a href="/perfume?id=' . $perfume['id'] . '">See detail</a> <a href="/delete?id=' . $perfume['id'] . '">Delete</a></td>
        </tr>
    ';
    array_push($rows, $row);
}

ob_start(); ?>
<h1><?= $title ?></h1>
<?php echo $successMessage ? '<p class="alert alert-success">' . $successMessage . '</p>' : null ?>
<?php echo $errorMessage ? '<p class="alert alert-danger">' . $errorMessage . '</p>' : null ?>
<div id="filters">
    <h2>Filters</h2>
    <form method="GET" class="filters">
        <div class="row">
            <div class="col">
                <label class="form-label">
                    <h3>Gender</h3>
                </label>
                <div class="input-group">
                    <select class="form-select" aria-label="Gender select" name="gender" id="gender">
                        <option value="0" <?= isset($_GET['gender']) && $_GET['gender'] == 0 ? 'selected' : null ?>>All</option>
                        <option value="1" <?= isset($_GET['gender']) && $_GET['gender'] == 1 ? 'selected' : null ?>>Men</option>
                        <option value="2" <?= isset($_GET['gender']) && $_GET['gender'] == 2 ? 'selected' : null ?>>Women</option>
                    </select>
                </div>
            </div>
            <div class="col">
                <label class="form-label">
                    <h3>Components</h3>
                </label>
                <div class="input-group components-checkboxes">
                    <?= implode('', $componentCheckboxes) ?>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Apply filters</button>
    </form>
</div>
<div class="perfumes">
    <h2>Perfumes</h2>
    <table class="table" id="perfumes-table">
        <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">For</th>
                <th scope="col">Description</th>
                <th scope="col">Components</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?= implode('', $rows) ?>
        </tbody>
    </table>
</div>
<?php $content = ob_get_clean();

require_once VIEWS_DIR . 'layout.php';
