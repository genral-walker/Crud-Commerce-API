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
        if (!self::$productModel) {
            self::$productModel = new ProductModel();
        }

        return self::$productModel;
    }

    protected function getAllProducts(): void
    {
        echo json_encode($this->productModel()->getAll());
    }

    protected function getProductBySKU(string $sku): void
    {
        echo json_encode($this->productModel()->get($sku));
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

        echo json_encode($this->productModel()->create(['Holda']));
    }
}
