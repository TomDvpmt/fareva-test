<?php

$title = 'Our perfumes';

$rows = [];

foreach ($data as $perfume) {
    $row = '<tr><td>' . $perfume['name'] .  '</td>
    <td>' . $perfume['description'] . '</td>
    <td>TODO : COMPONENTS</td>
</tr>';
    array_push($rows, $row);
}

ob_start(); ?>
<h1><?= $title ?></h1>
<div class="perfumes">
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Description</th>
                <th scope="col">Components</th>
            </tr>
        </thead>
        <tbody>
            <?= implode('', $rows) ?>
        </tbody>
    </table>
</div>
<?php $content = ob_get_clean();

require_once VIEWS_DIR . 'layout.php';
