<?php

declare(strict_types=1);

use App\Controllers\ProductController;
use App\Route;


if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, DELETE');
    header('Access-Control-Allow-Headers: Content-Type, Accept');
    header('Access-Control-Max-Age: 86400');
    header("Content-Length: 0");
    header("Content-Type: text/plain");
    exit();
}

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, DELETE');
header('Access-Control-Allow-Headers: Content-Type, Accept');
header("Content-type: application/json; charset=UTF-8");


require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


Route::get('/product/get', [ProductController::class, 'index']);
Route::post('/product/saveApi', [ProductController::class, 'store']);
Route::delete('/product/delete', [ProductController::class, 'destroy']);

Route::start();
