<?php
class Data
{
    //VALIDATIONS
    public static function onlyAlpha($key, $value, $allowEmpty = false)
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
    public static function onlyNum($key, $value, $allowEmpty = false)
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
    public static function onlyAlphaNum($key, $value, $allowEmpty = false, $allowSpace = true)
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
    public static function onlyDate($key, $value, $allowEmpty = false, $format = 'Y-m-d')
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
    public static function filterData($data, $expectedKeys)
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
    public static function fillMissingDataKeys($data, $expectedKeys)
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
    public static function mergeData($old, $new)
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
    public static function generateCSRFToken()
    {
        if (function_exists('random_bytes')) {
            // Generate 32 bytes of random data using a cryptographically secure function
            $randomBytes = random_bytes(32);
        } elseif (function_exists('openssl_random_pseudo_bytes')) {
            // Generate 32 bytes of random data using OpenSSL
            $randomBytes = openssl_random_pseudo_bytes(32);
        } else {
            // If neither random_bytes nor OpenSSL is available, fallback to a less secure method
            $randomBytes = uniqid(mt_rand(), true);
        }

        // Use a cryptographic function to create a secure hash of the random data
        $csrfToken = hash('sha256', $randomBytes);

        return $csrfToken;
    }
}