<?php

declare(strict_types=1);

use App\controllers\HomeController;
use App\Router;

/* Definitions */

define('DEVELOPMENT', $_SERVER['SERVER_NAME'] === 'localhost');
define('VIEWS_DIR', str_replace('public', 'src', $_SERVER['DOCUMENT_ROOT']) . '/views/');

/* Errors display */

if (DEVELOPMENT) {
    error_reporting(E_ALL);
    ini_set('display_errors', E_ALL);
}

/* Autoloading */
require_once '../vendor/autoload.php';


/* Launch App */
$router = new Router;
$router->callController();
