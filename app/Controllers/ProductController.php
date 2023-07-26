<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Abstracts\Controller;
use App\Models\ProductModel;

class ProductController extends Controller
{
    private static ?ProductModel $productModel = null;

    private function productModel(): ProductModel
    {
        if (!static::$productModel) {
            static::$productModel = new ProductModel();
        }

        return static::$productModel;
    }

    protected function getAllProducts(): void
    {
        $response = $this->productModel()->getAll();
        echo json_encode($response);
    }

    protected function getProductBySKU(string $sku): void
    {
        $response = $this->productModel()->get($sku);
        echo json_encode($response);
    }

    protected function resolveGetRequest(): void
    {
        $queries = $_SERVER['QUERY_STRING'] ?? '';
        parse_str($queries, $params);
        $productSKU = $params['sku'] ?? '';

        if ($productSKU) {
            $this->getProductBySKU($productSKU);
        } else {
            $this->getAllProducts();
        }
    }

    public function index(): void
    {
        $this->resolveGetRequest();
    }

    public function store(): void
    {
        $response = $this->productModel()->create(['Holda']);

        http_response_code($response['status']);
        echo json_encode($response);
    }
}
