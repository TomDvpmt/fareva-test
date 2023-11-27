<?php

namespace App\controllers;

class AbstractController
{
    public function view(string $name): void
    {
        require_once VIEWS_DIR . $name . '.view.php';
    }
}
