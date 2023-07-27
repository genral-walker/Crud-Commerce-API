<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Abstracts\Controller;
use App\ErrorHandler;
use App\Models\ProductModel;

class ProductController extends Controller
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


    public function index(): void
    {
        $this->resolveGetRequest();
    }


    public function store(): void
    {
        $requestBody = file_get_contents('php://input');
        $requestBody = json_decode($requestBody, true);

        $errors = $this->validateReqBody($requestBody);

        if ($errors) ErrorHandler::handleError(400, $errors);

        $validatedData = [];
        echo 'we got here';
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


    protected function getAllProducts(): void
    {
        $response = $this->productModel()->getAll();
        $message = empty($response) ? 'No products found.' : 'Products fetched successfully.';
        echo json_encode($this->dataResponse(200, $message, $response));
    }


    protected function getProductBySKU(string $sku): void
    {
        $response = $this->productModel()->get($sku);
        $message = empty($response) ? 'Product not found.' : "Product with sku: $sku fetched successfully.";
        echo json_encode($this->dataResponse(200, $message, $response));
    }


    protected function dataResponse(int $code, string $message, array $data = null): array
    {
        $response =  ['status' => $code, 'message' => $message];
        return  is_array($data) ? [...$response, 'data' => empty($data) ? [] : $data] :  $response;
    }


    protected function validateReqBody(array $requestBody): array
    {
        $requiredKeys = ["sku", "name", "price", "productType"];

        $errors = [];

        foreach ($requiredKeys as $key) {
            if (!key_exists($key, $requestBody) || !$requestBody[$key]) {
                $errors[] = "$key cannot be empty.";
            }
        }

        $price = $requestBody['price'] ?? null;

        if ($price && !is_numeric($price)) {
            $errors[] = 'Price can only be an integer or float.';
        }

        $productType = $requestBody['productType'] ?? null; //dvd, book, furniture

        if ($productType) {
            if (!key_exists($productType, self::PRODUCT_CATEGORIES)) {

                $errors[] = 'productType can only be one of three values: dvd, book, furniture.';
            } else {


                $unit = self::PRODUCT_CATEGORIES[$productType]; //size, weight, [height, width, length]

                $notIntError = function (array $requestBody, string $key) use (&$errors): void {
                    $unitValue =  $requestBody[$key] ?? null;

                    if (!is_int($unitValue)) {
                        $errors[] = "$key can only be an integer.";
                    }
                };

                if (is_array($unit)) {

                    foreach ($unit as $key) {
                        $notIntError($requestBody, $key);
                    }
                } else {

                    $notIntError($requestBody, $unit);
                }
            }
        }

        return $errors;
    }
}
