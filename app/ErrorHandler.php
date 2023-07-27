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
        http_response_code(500);
        echo json_encode([
            "code" => 500,
            "message" => $e->getMessage(),
            "file" => $e->getFile(),
            "line" => $e->getLine()
        ]);

        exit();
    }
}
