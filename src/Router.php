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

            case '/perfume':
                $controller = new PerfumeController;
                $controller->getPerfume();
                break;

            case '/add-perfume':
                $controller = new PerfumeController;
                $controller->addPerfume();
                break;

                // case '/update':
                //     $controller = new PerfumeController;
                //     $controller->updatePerfume();
                //     break;

            case '/delete':
                $controller = new PerfumeController;
                $controller->deletePerfume();
                break;

            default:
                require_once VIEWS_DIR . 'pages/404.view.php';
                break;
        }
    }
}
