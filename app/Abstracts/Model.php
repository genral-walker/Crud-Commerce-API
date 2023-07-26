<?php

declare(strict_types=1);

namespace App\Abstracts;

use App\DB;
use App\Config;

abstract class Model
{
    private static ?DB $db = null;

    public static function db(): DB
    {
        if (!static::$db) {
            $newConfig = new Config($_ENV);
            static::$db = new DB($newConfig->db);
        }

        return static::$db;
    }

    abstract public function getAll(): array;
    abstract public function get(string $sku): array;
    abstract public function create(array $data): array;
    abstract protected function dataResponse(int $code, string $message, array $data): array;
}
