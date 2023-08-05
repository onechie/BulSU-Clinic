<?php
// Check if the file is being directly accessed via URL
require_once("../middleware/accessMiddleware.php");
Access::preventDirectAccess();

class TokensController
{
    private $tokenModel;
    public function __construct(TokenModel $tokenModel)
    {
        $this->tokenModel = $tokenModel;
    }

    public function refreshAuthToken()
    {
        try {
            $refreshToken = $_COOKIE['refresh_token'] ?? null;

            if (!$refreshToken) {
                if (Auth::isAccessTokenValid()) {
                    return Response::successResponse("Welcome back!");
                }
                return Response::errorResponse("No refresh token.");
            }

            $refreshTokenData = $this->tokenModel->getTokenByRefreshToken($refreshToken);

            if (!$refreshTokenData) {
                return Response::errorResponse("Invalid refresh token.");
            }

            if (!Auth::isAccessTokenValid() && $refreshTokenData['expiration'] > date('Y-m-d H:i:s')) {
                Auth::generateAccessToken($refreshTokenData['userId']);
                return Response::successResponse("Welcome back!");
            }
        } catch (Throwable $error) {
            throw new Exception($error->getMessage());
        }
    }
}
