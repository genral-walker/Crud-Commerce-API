<?php

declare(strict_types=1);

namespace App\Models;

use App\Abstracts\Model;

class ProductModel extends Model
{
    protected function dataResponse(int $code, string $message, array $data = null): array
    {
        $response =  ['status' => $code, 'message' => $message];
        return  is_array($data) ? [...$response, 'data' => empty($data) ? [] : $data] :  $response;
    }

    public function getAll(): array
    {
        $query = 'SELECT * FROM products';
        $smt = $this->db()->query($query);

        return  $this->dataResponse(200, 'Products fetched successfully.', $smt->fetchAll());
    }

    public function get(string $sku): array
    {
        return  $this->dataResponse(200, "Product with sku: $sku fetched successfully.", ['Holla' => 'yes?']);
    }

    public function create(array $data): array
    {
        return  $this->dataResponse(201, "Product created successfully");
    }
}
