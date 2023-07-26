<?php

declare(strict_types=1);

namespace App\Abstracts;


abstract class Controller
{
    abstract protected function resolveGetRequest(): void;

    abstract protected function getAllProducts(): void;

    abstract protected function getProductBySKU(string $sku): void;

    abstract public function index(): void;
    abstract public function store(): void;
}
