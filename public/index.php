<?php

declare(strict_types=1);


/* Definitions */

define('DEVELOPMENT', $_SERVER['SERVER_NAME'] === 'localhost');
define('SITE_URL', '//' . $_SERVER['HTTP_HOST']);
define('VIEWS_DIR', str_replace('public', 'src', $_SERVER['DOCUMENT_ROOT']) . '/views/');
define('BRAND_NAME', 'Passion of Action');

/* Errors display */

if (DEVELOPMENT) {
    error_reporting(E_ALL);
    ini_set('display_errors', E_ALL);
}

/* Autoloading */
require_once '../vendor/autoload.php';

/* Environment variables */

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable("..");
$dotenv->load();


/* Launch App */

use App\Database;
use App\Router;

$database = new Database;
$database->initialize();

$router = new Router;
$router->callController();
