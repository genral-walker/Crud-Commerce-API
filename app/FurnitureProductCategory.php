<?php

declare(strict_types=1);

namespace App;

use App\Abstracts\ProductCategory;

class FurnitureProductCategory extends ProductCategory
{
    public function getAttributes(array $requestBody): array
    {
        return [
            'height' => $requestBody['height'],
            'width' => $requestBody['width'],
            'length' => $requestBody['length'],
            'size' => null,
            'weight' => null,
        ];
    }

    public function validateRequestBody(array $requestBody): array
    {
        $errors = [];

        foreach ($this->property as $property) {
            $value = $requestBody[$property] ?? null;
            $intError = $this->intError($property, $value);
            if ($intError) {
                $errors[] = $intError;
            }
        }

        return $errors;
    }
}
