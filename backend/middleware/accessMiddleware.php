<?php
class Access
{
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
