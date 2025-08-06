<?php

use Symfony\Component\HttpFoundation\Response;

if (!function_exists("errorResponse")) {
    function errorResponse(
        string $message,
        int $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR
    ) {
        return [
            "status" => $statusCode,
            "data" => [
                "message" => $message ?? __("message.error"),
                "success" => false,
            ],
        ];
    }
}

if (!function_exists("successResponse")) {
    function successResponse(array $data)
    {
        $data["success"] = true;
        return ["status" => Response::HTTP_OK, "data" => $data];
    }
}
