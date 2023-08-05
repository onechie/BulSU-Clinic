<?php
class Response
{
    public static function successResponse(string $message, $responseCode = 200, bool $isSuccess = true): array
    {
        http_response_code($responseCode);
        return ['success' => $isSuccess, 'message' => $message];
    }
    public static function successResponseWithData(string $message, array $data, $responseCode = 200, bool $isSuccess = true): array
    {
        http_response_code($responseCode);
        return ['success' => $isSuccess, 'message' => $message] + $data;
    }
    public static function errorResponse(string $message, $responseCode = 400): array
    {
        http_response_code($responseCode);
        return ['message' => $message];
    }
}
