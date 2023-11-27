<?php

namespace App\controllers;

class AbstractController
{
    public function view(): void
    {
        require_once VIEWS_DIR . 'pages/home.view.php';
    }
}
