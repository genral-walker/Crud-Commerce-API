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
        $query = 'INSERT INTO products (sku, name, price, productType, size, height, width, length, weight)
                  VALUES (:sku, :name, :price, :productType, :size, :height, :width, :length, :weight)';

        $smt = $this->db()->prepare($query);

        $smt->bindValue(":sku", $data["sku"]);
        $smt->bindValue(":name", $data["name"]);
        $smt->bindValue(":price", $data["price"]);
        $smt->bindValue(":productType", $data["productType"]);

        $productType = $data['productType'];
        $productCategory = $data['productCategories'][$productType];

        if (is_array($productCategory)) {

            foreach ($productCategory as $category) {
                $smt->bindValue(":$category", $data[$category]);
            }

            $smt->bindValue(":size", null);
            $smt->bindValue(":weight", null);
        } else {

            $smt->bindValue(":$productCategory", $data[$productCategory]);

            $smt->bindValue(":height", null);
            $smt->bindValue(":width", null);
            $smt->bindValue(":length", null);

            $nonDimensionTypes = ['weight', 'size'];

            $indexToRemove = array_search($productCategory, $nonDimensionTypes);

            unset($nonDimensionTypes[$indexToRemove]);
            $nonDimensionTypes =  array_values($nonDimensionTypes);

            $smt->bindValue(":$nonDimensionTypes[0]", null);
        }

        $smt->execute();

        return [];
    }
}
