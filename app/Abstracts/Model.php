<?php

declare(strict_types=1);

namespace App\Abstracts;

use App\DB;
use App\Config;

abstract class Model
{
    private static DB $db;
    public function __construct()
    {
        $newConfig = new Config($_ENV);

        static::$db = new DB($newConfig->db);
    }

    public static function db(): DB
    {
        return static::$db;
    }

    abstract public function getAll(): array | false;
    abstract public function get(string $query): array | false;
    abstract public function create(array $data): string;
}
