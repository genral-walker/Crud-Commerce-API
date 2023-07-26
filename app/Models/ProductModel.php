<?php

declare(strict_types=1);

namespace App\Models;

use App\Abstracts\Model;

class ProductModel extends Model
{

    public function getAll(): array
    {
        $query = 'SELECT * FROM products';
        $smt = $this->db()->query($query);

        return  $smt->fetchAll();
    }

    public function get(string $sku): array
    {
        $query = 'SELECT * FROM products WHERE sku=?';
        $smt = $this->db()->prepare($query);
        $smt->execute([$sku]);

        $product = $smt->fetch();

        return $product === false ? [] : $product;
    }

    public function create(array $data): array
    {
        return [];
    }
}
