<?php

declare(strict_types=1);

namespace App;

use App\Exceptions\RouteNotFoundException;
use Throwable;

class App
{
    private static DB $db;


    public function __construct(protected Route $router, protected array $request, protected Config $config)
    {
        static::$db = new DB($config->db ?? []);
    }

    public static function db(): DB
    {
        return static::$db;
    }

    public function run()
    {

        try {
            echo $this->router->start($this->request['uri'], strtolower($this->request['method']));
        } catch (Throwable) {
            http_response_code(404);
        }
    }
}
