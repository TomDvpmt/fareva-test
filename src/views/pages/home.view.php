<?php

$title = 'Our perfumes';
$successMessage = $data['successMessage'] ?? null;
$errorMessage = $data['errorMessage'] ?? null;

$rows = [];

foreach ($data as $perfume) {
    $components = implode(', ', $perfume['components']);

    $row = '<tr><td>' . $perfume['name'] .  '</td>
    <td>' . $perfume['description'] . '</td>
    <td>' . $components . '</td>
    <td><a href="/delete?id=' . $perfume['id'] . '">Delete</a></td>
</tr>';
    array_push($rows, $row);
}

ob_start(); ?>
<h1><?= $title ?></h1>
<?php echo $successMessage ? '<p class="alert alert-success">' . $successMessage . '</p>' : null ?>
<?php echo $errorMessage ? '<p class="alert alert-danger">' . $errorMessage . '</p>' : null ?>
<div class="filters">
    <form method="POST">
        <div class="row">
            <div class="col">
                <label class="form-label">Gender</label>
                <div class="input-group">
                    <select class="form-select" aria-label="Gender select" name="gender" id="gender">
                        <option value="0">All</option>
                        <option value="1">Men</option>
                        <option value="2">Women</option>
                    </select>
                </div>
            </div>
            <div class="col">
                <label class="form-label">Components</label>
                <div class="input-group">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">TODO COMPONENTS</label>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Apply filters</button>
    </form>
</div>
<div class="perfumes">
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">Name</th>
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
