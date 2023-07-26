<?php
//successResponse = Returns a success response with a message
//successResponseWithData = Returns a success response with a message and data
//errorResponse = Returns an error response with a message

//onlyAlphaNum() = Check a string if it contains only letters and numbers
//onlyAlpha() = Check a string if it contains only letters
//onlyNum() = Check a string if it contains only numbers
//onlyDate() = Check a string if it is a valid date

//preventDirectAccess() = Prevents direct access to the file
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

    protected function onlyAlpha($key, $value, $allowEmpty = false)
    {
        $value = trim($value);
        $value = str_replace(' ', '', $value);
        if (!$allowEmpty) {
            if ($value == "" || $value == null || empty($value)) {
                throw new Exception($key . ' value is empty.');
            }
        }
        if (!ctype_alpha($value)) {
            throw new Exception($key . ' value is not valid.');
        }
    }
    protected function onlyNum($key, $value, $allowEmpty = false)
    {
        if (!$allowEmpty) {
            if (($value == "" || $value == null || empty($value)) && $value != 0) {
                throw new Exception($key . ' value is empty.');
            }
        }
        if (!ctype_digit($value)) {
            throw new Exception($key . ' value is not valid.');
        }
    }
    protected function onlyAlphaNum($key, $value, $allowEmpty = false)
    {
        $value = trim($value);
        $value = str_replace(' ', '', $value);
        if (!$allowEmpty) {
            if ($value == "" || $value == null || empty($value)) {
                throw new Exception($key . ' value is empty.');
            }
        }
        if (!ctype_alnum($value)) {
            throw new Exception($key . ' value is not valid.');
        }
    }
    protected function onlyDate($key, $value, $allowEmpty = false, $format = 'Y-m-d')
    {
        if (!$allowEmpty) {
            if ($value == "" || $value == null || empty($value)) {
                throw new Exception($key . ' value is empty.');
            }
        }

        $date = DateTime::createFromFormat($format, $value);

        if ($date === false || $date->format($format) !== $value) {
            throw new Exception($key . ' value is not a valid date in the format ' . $format . '.');
        }
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
