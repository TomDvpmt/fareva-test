<?php

namespace App;

use App\controllers\HomeController;
use App\controllers\PerfumeController;

class Router
{
    public function callController(): void
    {
        $baseURI = explode('?', $_SERVER['REQUEST_URI'])[0];

        switch ($baseURI) {
            case '':
            case '/':
                $controller = new HomeController;
                $controller->index();
                break;

            case '/add-perfume':
                $controller = new PerfumeController;
                $controller->index();
                break;

            default:
                require_once VIEWS_DIR . 'pages/404.view.php';
                break;
        }
    }
}
