<?php

declare(strict_types=1);


/* Definitions */

define('DEVELOPMENT', $_SERVER['SERVER_NAME'] === 'localhost');
define('SITE_URL', '//' . $_SERVER['HTTP_HOST']);
define('VIEWS_DIR', str_replace('public', 'src', $_SERVER['DOCUMENT_ROOT']) . '/views/');
define('BRAND_NAME', 'Passion of Action');

define('MOCK_COMPONENTS', [
    'alcohol',
    'water',
    'limonene',
    'citral',
    'CI 14700 (red)',
    'CI 19140 (yellow)',
    'polysorbate 20',
    'sodium benzoate',
]);

// define('MOCK_PERFUMES', [
//     [
//         'name' => 'Perfume 1',
//         'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque metus turpis, tempus a molestie non, molestie at enim. In dignissim lectus nec sapien pellentesque, nec condimentum purus lacinia. Aliquam erat volutpat. Quisque non blandit nibh, nec bibendum ipsum. Aenean dignissim tincidunt lorem, suscipit luctus urna ullamcorper non.',
//         'gender' => 1,
//         'components' => [
//             'alcohol',
//             'water',
//             'CI 14700 (red)',
//         ]
//     ],
//     [
//         'name' => 'Perfume 2',
//         'description' => 'Nulla cursus arcu dolor, a tincidunt est dapibus nec. Interdum et malesuada fames ac ante ipsum primis in faucibus. Curabitur ut placerat arcu, in ultricies orci. Maecenas vel nisl quis sem imperdiet pellentesque ut in quam. Sed sagittis elementum luctus. Suspendisse sodales felis magna.',
//         'gender' => 2,
//         'components' => [
//             'alcohol',
//             'water',
//             'polysorbate 20',
//             'sodium benzoate',
//         ]
//     ],
//     [
//         'name' => 'Perfume 3',
//         'description' => 'Mauris nulla dui, rutrum quis pretium eu, tincidunt quis arcu. Pellentesque velit ipsum, lacinia quis sapien vel, vulputate tristique nunc. Nulla pellentesque, justo vel pellentesque efficitur, urna massa maximus nisi, in elementum odio quam et libero. Cras accumsan a ex sit amet ornare.',
//         'gender' => 2,
//         'components' => [
//             'alcohol',
//             'limonene',
//             'citral',
//             'sodium benzoate',
//         ]
//     ]

// ]);

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
