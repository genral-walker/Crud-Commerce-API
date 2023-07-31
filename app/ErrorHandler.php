<?php

declare(strict_types=1);

namespace App;

use Throwable;

class ErrorHandler
{
    public static function handleError(int $status, string|array $message): void
    {
        http_response_code($status);

        echo json_encode([
            'status' => $status,
            'message' => $message,
        ]);

        exit();
    }

    public static function handleThrowableError(Throwable $e): void
    {
        $word1 = "Integrity constraint violation: 1062 Duplicate entry";
        $word2 = "for key 'sku'";

        $message = $e->getMessage();
        $response = [];

        if (strpos($message, $word1) !== false && strpos($message, $word2) !== false) {
            $response = [
                "status" => 400,
                "message" => 'Duplicate entry. Product with sku already created, please change the sku.'
            ];
        } else {
            $response = [
                "status" => 500,
                "message" => $message,
                "file" => $e->getFile(),
                "line" => $e->getLine()
            ];
        }

        http_response_code($response['status']);
        echo json_encode($response);

        exit();
    }
}
