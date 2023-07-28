<?php

declare(strict_types=1);

namespace App\Abstracts;

use App\Models\ProductModel;

abstract class Controller
{
    private static ?ProductModel $productModel = null;
    const PRODUCT_CATEGORIES = [
        'dvd' => 'size',
        'book' => 'weight',
        'furniture' => ['height', 'width', 'length']
    ];
    protected function productModel(): ProductModel
    {
        if (!static::$productModel) {
            static::$productModel = new ProductModel();
        }

        return static::$productModel;
    }

    abstract public function index(): void;

    abstract public function store(): void;

    abstract public function destroy(): void;

    abstract protected function resolveGetRequest(): void;

    abstract protected function dataResponse(int $code, string $message, array $data): array;

    abstract protected function getAllProducts(): void;

    abstract protected function getProductBySKU(string $sku): void;

    abstract protected function validateReqBody(array $requestBody): array;
}
