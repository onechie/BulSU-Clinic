<?php
//successResponse = Returns a success response with a message
//successResponseWithData = Returns a success response with a message and data
//errorResponse = Returns an error response with a message

//onlyAlphaNum() = Check a string if it contains only letters and numbers
//onlyAlpha() = Check a string if it contains only letters
//onlyNum() = Check a string if it contains only numbers
//onlyDate() = Check a string if it is a valid date

//filterData() = Filter data based on the expected keys and sequence, trim each value, and remove empty values;
//fillMissingDataKeys() = Fill missing keys of array base on expectedKeys
//mergeData() = Merge old and new data (associative array), and compare the old and merged data if there are difference.

//hasFiles() = Check if there are files.
//formatFiles() = Format the files to be uploaded from default format to associative array.
//validateFiles() = Validate the files if it is valid.
//uploadFiles() = Upload the files to the server.


//preventDirectAccess() = Prevents direct access to the file
class Utility
{
    private $allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt'];
    private $allowedMimeTypes = ['image/jpeg', 'image/png', 'application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation'];
    private $maxFileSize = 1048576 * 5; //1MB * 5 = 5MB

    //RESPONSE TEMPLATE
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

    //VALIDATIONS
    protected function onlyAlpha($key, $value, $allowEmpty = false)
    {
        $value = str_replace(' ', '', $value);
        if (!$allowEmpty) {
            if ($value == "" || $value == null || empty($value)) {
                throw new Exception($key . ' is empty.');
            }
        }
        if (!ctype_alpha($value)) {
            throw new Exception($key . ' must be letters.');
        }
    }
    protected function onlyNum($key, $value, $allowEmpty = false)
    {
        if (!$allowEmpty) {
            if (($value == "" || $value == null || empty($value)) && $value != "0") {
                throw new Exception($key . ' is empty.');
            }
        }
        // if (!ctype_digit($value)) {
        //     throw new Exception($key . ' must be a number.');
        // }
        if (!filter_var($value, FILTER_VALIDATE_INT)) {
            throw new Exception($key . ' must be a number(integer).');
        }
    }
    protected function onlyAlphaNum($key, $value, $allowEmpty = false, $allowSpace = true)
    {
        $pattern = '/^[A-Za-z0-9\/._@+&-]+$/';

        if ($allowSpace) {
            $pattern = '/^[A-Za-z0-9 \/._@+&-]+$/';
        }
        if (!$allowEmpty) {
            if ($value == "" || $value == null || empty($value)) {
                throw new Exception($key . ' is empty.');
            }
        }
        if (!preg_match($pattern, $value)) {
            throw new Exception($key . ' should only contain(a-z A-Z 0-9 @+&_./-)');
        }
    }
    protected function onlyDate($key, $value, $allowEmpty = false, $format = 'Y-m-d')
    {
        if (!$allowEmpty) {
            if ($value == "" || $value == null || empty($value)) {
                throw new Exception($key . ' is empty.');
            }
        }

        $date = DateTime::createFromFormat($format, $value);

        if ($date === false || $date->format($format) !== $value) {
            throw new Exception($key . ' is not valid in the format ' . $format . '.');
        }
    }

    //DATA SANITATION
    protected function filterData($data, $expectedKeys)
    {
        // REMOVE WHITE SPACES
        $removeWhiteSpaces = array_map(function ($value) {
            return trim($value);
        }, $data);

        // REMOVE EMPTY VALUES
        $removeEmptyValues = array_filter($removeWhiteSpaces, function ($value) {
            return !empty($value) || $value === 0 || $value === '0';
        });

        // REMOVE UNEXPECTED KEYS AND SORT BY EXPECTED KEYS
        $finalData = [];
        foreach ($expectedKeys as $key) {
            if (isset($removeEmptyValues[$key])) {
                $finalData[$key] = $removeEmptyValues[$key];
            }
        }

        return $finalData;
    }

    //DATA FILLER
    protected function fillMissingDataKeys($data, $expectedKeys)
    {
        $finalData = [];
        foreach ($expectedKeys as $key) {
            if (isset($data[$key])) {
                $finalData[$key] = $data[$key];
            } else {
                $finalData[$key] = "";
            }
        }
        return $finalData;
    }

    //DATA UPDATE CHECKER AND MERGER
    protected function mergeData($old, $new)
    {
        $finalData = array_merge($old, $new);

        $differences = array_diff_assoc($old, $finalData);
        if (empty($differences)) {
            throw new Exception('No changes were made.');
        }
        unset($finalData['created_at']);
        unset($finalData['updated_at']);
        return $finalData;
    }

    //FILE HANDLING
    protected function hasFiles($files)
    {
        $files = $files['attachments']['name'][0] ?? null;
        if ($files == null) {
            return false;
        }
        return true;
    }
    protected function formatFiles($files)
    {
        $filesCount = count($files['name']);
        $newFilesFormat = [];
        for ($i = 0; $i < $filesCount; $i++) {
            $newFilesFormat[$i] = [
                'name' => $files['name'][$i],
                'tmp_name' => $files['tmp_name'][$i],
                'size' => $files['size'][$i],
                'error' => $files['error'][$i],
                'type' => $files['type'][$i],
            ];
        }
        return $newFilesFormat;
    }
    protected function validateFiles($files)
    {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);

        foreach ($files as $key => $value) {

            $file = $value['name'];
            $fileSize = $value['size'];
            $fileError = $value['error'];
            $tmpName = $value['tmp_name'];

            $fileExt = explode('.', $file);
            $fileActualExt = strtolower(end($fileExt));
            $mime_type = finfo_file($finfo, $tmpName);

            if (!in_array($fileActualExt, $this->allowedExtensions)) {
                throw new Exception($fileActualExt . " file type not allowed.");
            }
            if (!in_array($mime_type, $this->allowedMimeTypes)) {
                throw new Exception($mime_type . " file type not allowed.");
            }
            if ($fileError !== UPLOAD_ERR_OK) {
                throw new Exception("Error uploading " . $file . " file.");
            }
            if ($fileSize > $this->maxFileSize) {
                throw new Exception("File size of " . $file . " is too big.");
            }
        }
        finfo_close($finfo);
    }
    protected function uploadFiles($files, $id = 0)
    {
        $uploadedFilesData = [];
        $baseDirectory = '../../src/attachments/';
        if (!is_dir($baseDirectory)) {
            mkdir($baseDirectory, 0777, true);
        }
        foreach ($files as $key => $value) {

            $file = $value['name'];
            $fileTmpName = $value['tmp_name'];
            $fileExt = explode('.', $file);
            $fileActualExt = strtolower(end($fileExt));

            $fileDirectory = '../../src/attachments/' . $id . '/';

            if (!is_dir($fileDirectory)) {
                mkdir($fileDirectory, 0777, true);
            }

            $fileNameNew = uniqid('', true) . "." . $fileActualExt;

            $fileDestination = $fileDirectory . $fileNameNew;
            if (!move_uploaded_file($fileTmpName, $fileDestination)) {
                throw new Exception("Error uploading file.");
            }
            $uploadedFilesData[$file] = [
                'name' => $fileNameNew,
                'url' => $fileDestination,
            ];
        }
        return $uploadedFilesData;
    }
    protected function deleteFiles($files, $recordId, $alsoDirectory = false)
    {
        foreach ($files as $key => $value) {
            $file = $value['url'];
            if (file_exists($file)) {
                unlink($file);
            }
        }
        if ($alsoDirectory) {
            $fileDirectory = '../../src/attachments/' . $recordId . '/';
            if (is_dir($fileDirectory)) {
                rmdir($fileDirectory);
            }
        }
    }
    protected function deleteFile($url)
    {
        if (file_exists($url)) {
            unlink($url);
        }
    }

    //AUTHENTICATION HANDLING
    protected function generateRandomBytes($length)
    {
        if (function_exists('random_bytes')) {
            return random_bytes($length);
        } elseif (function_exists('openssl_random_pseudo_bytes')) {
            return openssl_random_pseudo_bytes($length);
        } else {
            return uniqid(mt_rand(), true);
        }
    }

    protected function generateRefreshToken($length = 32)
    {
        $randomBytes = $this->generateRandomBytes($length);
        $refreshToken = rtrim(strtr(base64_encode($randomBytes), '+/', '-_'), '=');
        return $refreshToken;
    }

    protected function generateAccessToken(int $userId)
    {
        
        $randomBytes = $this->generateRandomBytes(32);
        $authToken = bin2hex($randomBytes);

        $half_hour_expiration = time() + 1800; // 30 minutes
        $tokenGracePeriod = 300; // 5 minutes

        $auth = [
            'token' => $authToken,
            'expiry' => $half_hour_expiration,
            'user_id' => $userId
        ];

        $_SESSION['ACCESS'] = $auth;
        setcookie('access_token', $auth['token'], $auth['expiry'] + $tokenGracePeriod, '/', '', false, true);
    }
    protected function isAccessTokenValid()
    {


        $auth = $_SESSION['ACCESS'] ?? null;
        if (!$auth) {
            return false;
        }

        $tokenGracePeriod = 300;
        $currentTime = time();

        if ($auth['expiry'] + $tokenGracePeriod < $currentTime) {
            return false;
        }

        $authToken = $_COOKIE['access_token'] ?? null;
        if (!$authToken || !hash_equals($authToken, $auth['token'])) {
            return false;
        }

        if ($auth['expiry'] < $currentTime) {
            $this->generateAccessToken($auth['user_id']);
        }
        return true;
    }

    // FILE DIRECT ACCESS PREVENTION
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
