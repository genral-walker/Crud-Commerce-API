<?php

declare(strict_types=1);

use App\App;
use App\Config;
use App\Controllers\ProductController;
use App\Route;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type, Accept');
header("Content-type: application/json; charset=UTF-8");


require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


Route::get('/product/get', [ProductController::class, 'index']);
Route::post('/product/saveApi', [ProductController::class, 'store']);

Route::start();




// (new App(
//     $router,
//     ['uri' => $_SERVER['REQUEST_URI'], 'method' => $_SERVER['REQUEST_METHOD']],
//     new Config($_ENV)
// ))->run();


/**
 * First understand the project scopes and user stories
 * Create the tables
 * Create the routes and their methods*/
