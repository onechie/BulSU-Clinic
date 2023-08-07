<?php

use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;
use \Firebase\JWT\SignatureInvalidException;
use \Firebase\JWT\ExpiredException;

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__, __DIR__ . "../../.env");
$dotenv->load();

class Auth
{
    public static function encodeAccessJWT($id, $username)
    {
        try {
            $data = [
                "iss" => $_ENV['JWT_ISSUER'],
                "sub" => $id,
                "aud" => $_ENV['JWT_ISSUER'],
                "exp" => time() + (60 * 20),
                "iat" => time(),
                "type" => "ACCESS",
                "role" => "NURSE",
                "username" => $username,
            ];
            $jwt = JWT::encode($data, $_ENV['JWT_SECRET'], $_ENV['JWT_ENC']);
            // 25mins expiration
            setcookie('a_jwt', $jwt, time() + (60 * 20), '/', '', false, true);
            return $jwt;
        } catch (Throwable $e) {
            return false;
        }
    }
    public static function encodeRefreshJWT($id, $username, $email)
    {
        try {
            $data = [
                "iss" => $_ENV['JWT_ISSUER'],
                "sub" => $id,
                "aud" => $_ENV['JWT_ISSUER'],
                "exp" => time() + (60 * 60 * 24 * 7),
                "iat" => time(),
                "type" => "REFRESH",
                "role" => "NURSE",
                "username" => $username,
                "email" => $email,
            ];
            $jwt = JWT::encode($data, $_ENV['JWT_SECRET'], $_ENV['JWT_ENC']);
            // 7 days expiration
            setcookie('r_jwt', $jwt, time() + (60 * 60 * 24 * 7), '/', '', false, true);
            return $jwt;
        } catch (Throwable $e) {
            return false;
        }
    }
    public static function validateAccessJWT($jwt)
    {
        $key = new Key($_ENV['JWT_SECRET'], $_ENV['JWT_ENC']);
        try {
            $data = JWT::decode($jwt, $key);
            // check issuer and audience
            if ($data->iss !== $_ENV['JWT_ISSUER'] || $data->aud !== $_ENV['JWT_ISSUER']) {
                return false;
            }
            //check if type is access
            if ($data->type !== "ACCESS") {
                return false;
            }
            // check if token is expiring in 5 mins
            if ($data->exp < time() + (60 * 5)) {
                //refresh if expiring
                $newJwt = self::encodeAccessJWT($data->sub, $data->username);
                $data = JWT::decode($newJwt, $key);
            }
            return $data;
        } catch (SignatureInvalidException $e) {
            throw new Exception("Invalid access token.");
        } catch (ExpiredException $e) {
            throw new Exception("Access token expired.");
        } catch (Throwable $e) {
            throw new Exception("Tampered access token detected.");
        }
    }
    public static function validateRefreshJWT($jwt)
    {
        $key = new Key($_ENV['JWT_SECRET'], $_ENV['JWT_ENC']);
        try {
            $data = JWT::decode($jwt, $key);
            // check issuer and audience
            if ($data->iss !== $_ENV['JWT_ISSUER'] || $data->aud !== $_ENV['JWT_ISSUER']) {
                return false;
            }
            //check if type is refresh
            if ($data->type !== "REFRESH") {
                return false;
            }
            // check if token is expiring in 2 days
            if ($data->exp < time() + (60 * 60 * 24 * 2)) {
                //refresh if expiring
                $newJwt = self::encodeRefreshJWT($data->sub, $data->username, $data->email);
                $data = JWT::decode($newJwt, $key);
            }
            return $data;
        } catch (SignatureInvalidException $e) {
            throw new Exception("Invalid refresh token.");
        } catch (ExpiredException $e) {
            throw new Exception("Refresh token expired.");
        } catch (Throwable $e) {
            throw new Exception("Tampered refresh token detected.");
        }
    }
    // public static function generateRandomBytes($length)
    // {
    //     if (function_exists('random_bytes')) {
    //         return random_bytes($length);
    //     } elseif (function_exists('openssl_random_pseudo_bytes')) {
    //         return openssl_random_pseudo_bytes($length);
    //     } else {
    //         return uniqid(mt_rand(), true);
    //     }
    // }
    // public static function generateCSRFToken($length = 32)
    // {
    //     $randomBytes = self::generateRandomBytes($length);
    //     $csrfToken = hash('sha256', $randomBytes);

    //     return $csrfToken;
    // }
}
