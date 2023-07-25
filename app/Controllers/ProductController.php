<?php

declare(strict_types=1);

namespace App\Controllers;

class ProductController
{
    public function index(): void
    {
        echo 'We Loaded the landing route';
        
    }

    public function store(): void
    {

        echo 'We Loaded the store route';
    }
}
