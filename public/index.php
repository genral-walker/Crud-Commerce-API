<?php

declare(strict_types=1);


require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();


/**
 * First understand the project scopes and user stories
 * Create the tables
 * Create the routes and their methods*/
