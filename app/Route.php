<?php

declare(strict_types=1);

namespace App;

class Route extends ErrorHandler
{
    private static array $routes;

    public static function get(string $route, array $action): void
    {
        self::$routes['get'][$route] = $action;
    }

    public static function post(string $route, array $action): void
    {
        self::$routes['post'][$route] = $action;
    }

    public static function start()
    {
        $requestUri = $_SERVER['PATH_INFO'];
        $requestMethod = strtolower($_SERVER['REQUEST_METHOD']);
        $routes = self::$routes;
        $action = $routes[$requestMethod][$requestUri];


        if (!isset($routes[$requestMethod])) {
            self::handleError(405, 'Invalid request method, only GET and POST requests allowed. Method: ' . strtoupper($requestMethod));
        }

        if (!isset($action)) {
            self::handleError(404, 'API route not found.');
        }

        [$class, $method] = $action;

        if (class_exists($class)) {
            $class = new $class();

            if (method_exists($class, $method)) {
                return call_user_func_array([$class, $method], []);
            }
        }
        // echo json_encode(['requestUri' => $requestUri, 'requestMethod' => $requestMethod, 'routes' => $routes]);

        self::handleError(400, "Invalid action format. Expected [ClassName::class, 'methodName'] at index.php");
    }
}
