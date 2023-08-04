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
            if (session_status() !== PHP_SESSION_ACTIVE) {
                session_start();
            }

            $refreshToken = $_COOKIE['refresh_token'] ?? null;

            if (!$refreshToken) {
                if ($this->isAccessTokenValid()) {
                    return $this->successResponse("Welcome back!");
                }
                return $this->errorResponse("No refresh token.");
            }

            $refreshTokenData = $this->tokenModel->getTokenByRefreshToken($refreshToken);

            if (!$refreshTokenData) {
                return $this->errorResponse("Invalid refresh token.");
            }

            if (!$this->isAccessTokenValid() && $refreshTokenData['expiration'] > date('Y-m-d H:i:s')) {
                $this->generateAccessToken($refreshTokenData['userId']);
                return $this->successResponse("Welcome back!");
            }
        } catch (Throwable $error) {
            throw new Exception($error->getMessage());
        }
    }
}
