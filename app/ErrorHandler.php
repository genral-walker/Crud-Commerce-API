<?php

declare(strict_types=1);

namespace App;

class ErrorHandler
{
    public static function handleError(int $status, string $message): void
    {
        http_response_code($status);

        echo json_encode([
            'status' => $status,
            'message' => $message,
        ]);

        exit();
    }
}
