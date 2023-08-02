<?php
// Check if the file is being directly accessed via URL
require_once("../utils/utility.php");
Utility::preventDirectAccess();

class TokensController extends Utility
{
    private $tokenModel;
    public function __construct(TokenModel $tokenModel)
    {
        $this->tokenModel = $tokenModel;
    }

    public function refreshAuthToken()
    {
        try {
            session_start();
            $one_hour_expiration = time() + 60 * 60;
            $auth = $_SESSION['ACCESS'] ?? null;
            $refreshToken = $_COOKIE['refresh_token'] ?? null;

            if (!$refreshToken) {
                return $this->errorResponse("No refresh token found.");
            }
            $checkToken = $this->tokenModel->getTokenByRefreshToken($refreshToken);
            if (!$checkToken) {
                return $this->errorResponse("Invalid refresh token.");
            }
            if (empty($auth['token']) || $auth['expiry'] < time()) {
                $auth['token'] = $this->generateAuthToken();
                $auth['expiry'] = $one_hour_expiration;
                $auth['user_id'] = $checkToken['userId'];
                $_SESSION['ACCESS'] = $auth;
            }
            setcookie('access_token', $auth['token'], $auth['expiry'], '/', '', false, true);
            return $this->successResponse("Welcome back!");
        } catch (Throwable $error) {
            throw new Exception($error->getMessage());
        }
    }

    private function generateAuthToken()
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

        // Convert the random bytes to a hexadecimal string
        $authToken = bin2hex($randomBytes);

        return $authToken;
    }
    private function validateAuthToken($authToken)
    {
        if (!hash_equals($_SESSION['ACCESS']['token'], $authToken)) {
            return false;
        }
        return true;
    }
}
