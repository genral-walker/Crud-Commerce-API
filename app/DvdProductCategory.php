<?php

declare(strict_types=1);

namespace App;

use App\Abstracts\ProductCategory;

class DvdProductCategory extends ProductCategory
{
    public function getAttributes(array $requestBody): array
    {
        return [
            'size' => $requestBody['size'],
            'weight' => null,
            'height' => null,
            'width' => null,
            'length' => null,
        ];
    }
}
