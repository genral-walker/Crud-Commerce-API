<?php

declare(strict_types=1);

namespace App\Models;

use App\Abstracts\Model;

class ProductModel extends Model
{
    public function getAll(): array | false
    {
        return ['the get all code'];
    }

    public function get(string $query): array | false
    {
        return ['the get code'];
    }

    public function create(array $data): string
    {
        return 'the create string';
    }
}
