<?php
class Auth
{
    public static function generateRandomBytes($length)
    {
        if (function_exists('random_bytes')) {
            return random_bytes($length);
        } elseif (function_exists('openssl_random_pseudo_bytes')) {
            return openssl_random_pseudo_bytes($length);
        } else {
            return uniqid(mt_rand(), true);
        }
    }

    public static function generateRefreshToken($length = 32)
    {
        $randomBytes = self::generateRandomBytes($length);
        $refreshToken = rtrim(strtr(base64_encode($randomBytes), '+/', '-_'), '=');
        return $refreshToken;
    }

    public static function generateAccessToken(int $userId)
    {

        $randomBytes = self::generateRandomBytes(32);
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
    public static function isAccessTokenValid()
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
            self::generateAccessToken($auth['user_id']);
        }
        return true;
    }
}
