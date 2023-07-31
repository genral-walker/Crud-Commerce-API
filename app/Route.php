<?php

declare(strict_types=1);

namespace App;

use Throwable;

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

    public static function delete(string $route, array $action): void
    {
        self::$routes['delete'][$route] = $action;
    }

    public static function start()
    {
        try {

            $getRequestURL = function (): string {
                $requiredURL = strstr($_SERVER['REQUEST_URI'], '/product');

                if ($requiredURL !== false) {
                    $questionMarkPosition = strpos($requiredURL, '?');

                    if ($questionMarkPosition !== false) {
                        return substr($requiredURL, 0, $questionMarkPosition);
                    } else {
                        return $requiredURL;
                    }
                }
                return '';
            };


            $requestMethod = strtolower($_SERVER['REQUEST_METHOD']);
            $routes = self::$routes;
            $action = $routes[$requestMethod][$getRequestURL()] ?? null;


            if (!isset($routes[$requestMethod])) {
                self::handleError(405, 'Invalid request method, only GET, POST and DELETE requests allowed. Method: ' . strtoupper($requestMethod));
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

            self::handleError(400, "Invalid action format. Expected [ClassName::class, 'methodName'] at index.php");
        } catch (Throwable $e) {
            self::handleThrowableError($e);
        }
    }
}
