<?php

declare(strict_types=1);

namespace App\Abstracts;

use App\Models\ProductModel;

abstract class Controller
{
    abstract protected function productModel(): ProductModel;

    abstract public function index(): void;

    abstract public function store(): void;

    abstract protected function resolveGetRequest(): void;

    abstract protected function dataResponse(int $code, string $message, array $data): array;

    abstract protected function getAllProducts(): void;

    abstract protected function getProductBySKU(string $sku): void;

    abstract protected function validateReqBody(array $requestBody): array;
}
