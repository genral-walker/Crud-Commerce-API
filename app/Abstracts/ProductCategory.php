<?php

declare(strict_types=1);

namespace App\Abstracts;

abstract class ProductCategory
{
    protected string|array $property;

    public function __construct(string $category)
    {
        $productProperties = [
            'dvd' => 'size',
            'book' => 'weight',
            'furniture' => ['height', 'width', 'length']
        ];
        
        $this->property = $productProperties[$category];
    }

    protected function intError(string $property, mixed $value): string
    {
        if (!$value) {
            return "$property cannot be empty.";
        }

        if (!is_int($value) || $value < 1) {
            return "$property should be a positive integer.";
        }

        return '';
    }

    public function validateRequestBody(array $requestBody): array
    {
        $errors = [];
        $value = $requestBody[$this->property] ?? null;

        $intError = $this->intError($this->property, $value);

        return $intError ? [...$errors, $intError] : $errors;
    }

    abstract public function getAttributes(array $requestBody): array;
}
