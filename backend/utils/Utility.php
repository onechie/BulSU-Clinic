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
    public static function preventDirectAccess()
    {
        $isDirectAccess = (count(debug_backtrace()) <= 1);

        if ($isDirectAccess) {
            http_response_code(403);
            header('Content-Type: application/json');
            $response = [
                "message" => "Direct access is not allowed."
            ];
            echo json_encode($response);
            exit;
        }
    }
}
