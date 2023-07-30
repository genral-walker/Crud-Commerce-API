<?php

declare(strict_types=1);

namespace App;

use App\Abstracts\ProductCategory;

class BookProductCategory extends ProductCategory
{
    public function getAttributes(array $requestBody): array
    {
        return [
            'weight' => $requestBody['weight'],
            'height' => null,
            'width' => null,
            'length' => null,
            'size' => null,
        ];
    }

}
