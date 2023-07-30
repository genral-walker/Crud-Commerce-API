<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Abstracts\Controller;
use App\ErrorHandler;

class ProductController extends Controller
{
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


        $productType = $requestBody['productType'];

        $productCategory = $this->getProductCategory($productType);

        $validatedData = [
            ':sku' => $requestBody['sku'],
            ':name' => $requestBody['name'],
            ':price' => $requestBody['price'],
            ':productType' => $productType
        ];

        $attributes = $productCategory->getAttributes($requestBody);

        foreach ($attributes as $attributeKey => $attributeValue) {
            $validatedData[":$attributeKey"] = $attributeValue;
        }

        $this->productModel()->create($validatedData);

        http_response_code(201);
        echo json_encode($this->dataResponse(201, 'Product created successfully.'));
    }



    public function destroy(): void
    {
        $requestBody = file_get_contents('php://input');
        $requestBody = json_decode($requestBody, true) ?? [];

        if (count($requestBody) > 0) {
            $rowCount = $this->productModel()->delete($requestBody);
            $isMultiple = $rowCount > 1 ? 's' : '';
            $message = $rowCount ? $rowCount . ' product' . $isMultiple . ' deleted successfully.' : 'No product deleted';

            echo json_encode($this->dataResponse(200, $message));
        } else {
            ErrorHandler::handleError(400, "No product selected");
        }
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

        if ($price && (!is_numeric($price) || $price < 1)) {
            $errors[] = 'Price can only be a positive integer or float.';
        }

        $productType = $requestBody['productType'] ?? '';

        $productType = $this->getProductCategory($productType);

        return [...$errors, ...$productType->validateRequestBody($requestBody)];
    }
}
