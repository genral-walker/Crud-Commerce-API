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

    public function create(array $data): void
    {
        $query = 'INSERT INTO products (sku, name, price, productType, size, height, width, length, weight)
                  VALUES (:sku, :name, :price, :productType, :size, :height, :width, :length, :weight)';

        $smt = $this->db()->prepare($query);

        foreach ($data as $key => $value) {
            $smt->bindValue("$key", $value);
        }

        $smt->execute();
    }

    public function delete(array $skuArray): int
    {
        $placeholders = implode(',', array_fill(0, count($skuArray), '?'));
        $query = "DELETE FROM products WHERE sku IN ($placeholders)";
        $smt = $this->db()->prepare($query);

        $smt->execute($skuArray);
        return $smt->rowCount();
    }
}
