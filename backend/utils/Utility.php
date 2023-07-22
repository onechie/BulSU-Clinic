<?php
class Utility
{
    protected function successResponse(string $message): array
    {
        return ['success' => true, 'message' => $message];
    }
    protected function successResponseWithData(string $message, array $data): array
    {
        return ['success' => true, 'message' => $message] + $data;
    }
    protected function errorResponse(string $message): array
    {
        return ['success' => false, 'message' => $message];
    }
}
