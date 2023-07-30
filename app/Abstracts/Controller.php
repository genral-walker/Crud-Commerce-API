<?php

declare(strict_types=1);

namespace App\Abstracts;

use App\BookProductCategory;
use App\DvdProductCategory;
use App\ErrorHandler;
use App\FurnitureProductCategory;
use App\Models\ProductModel;

abstract class Controller
{
    private static ?ProductModel $productModel = null;

    public function productModel(): ProductModel
    {
        if (!static::$productModel) {
            static::$productModel = new ProductModel();
        }

        return static::$productModel;
    }

    protected function getProductCategory(string $productType): ProductCategory
    {
        $categoryClasses = [
            'dvd' => DvdProductCategory::class,
            'book' => BookProductCategory::class,
            'furniture' => FurnitureProductCategory::class,
        ];

        if (isset($categoryClasses[$productType])) {
            return new $categoryClasses[$productType]($productType);
        } else {
            ErrorHandler::handleError(400, 'productType can only be one of three values: dvd, book, furniture.');
        }
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
