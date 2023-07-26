<?php

declare(strict_types=1);

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
