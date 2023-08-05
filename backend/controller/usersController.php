<?php
// Check if the file is being directly accessed via URL
require_once("../middleware/accessMiddleware.php");
Access::preventDirectAccess();
class UsersController
{
    private $userModel;
    private $tokenModel;

    public function __construct(UserModel $userModel, TokenModel $tokenModel)
    {
        $this->userModel = $userModel;
        $this->tokenModel = $tokenModel;
    }

    public function registerUser($req)
    {
        $expectedKeys = ['username', 'email', 'password', 'confirmPassword', 'agreement', 'X-CSRF-TOKEN'];
        $req = Data::filterData($req, $expectedKeys);
        try {
            $this->validateUserData($req);
            $this->isUsernameExists($req['username']);
            $this->isEmailExists($req['email']);
            if (filter_var($req['agreement'], FILTER_VALIDATE_BOOLEAN) === false) {
                return Response::errorResponse("You must agree to the terms and policies.");
            }
            $req['password'] = password_hash($req['password'], PASSWORD_DEFAULT);
            $result = $this->userModel->addUser(...array_values($req));
            if ($result) {
                return Response::successResponse($req['username'] . " registered successfully.");
            } else {
                return Response::errorResponse("User registration failed.");
            }
        } catch (Throwable $error) {
            return Response::errorResponse($error->getMessage());
        }
    }
    public function loginUser($req)
    {
        $expectedKeys = ['usernameOrEmail', 'password', 'keepLoggedIn', 'X-CSRF-TOKEN'];
        $req = Data::filterData($req, $expectedKeys);
        try {
            Data::onlyAlphaNum("Username or email", $req['usernameOrEmail'] ?? null);
            if (!isset($req['password'])) {
                return Response::errorResponse("Password is empty.");
            }
            $user = $this->userModel->getUserByEmail($req['usernameOrEmail']);
            if (!$user) {
                $user = $this->userModel->getUserByUsername($req['usernameOrEmail']);
            }
            if (!$user) {
                return Response::errorResponse("Invalid Credentials.");
            }
            if (password_verify($req['password'], $user['password'])) {
                if (filter_var($req['keepLoggedIn'], FILTER_VALIDATE_BOOLEAN)) {
                    $refreshToken = Auth::generateRefreshToken();
                    $token = $this->tokenModel->addToken($refreshToken, $user['id'], date('Y-m-d', strtotime('+1 week')));
                    if (!$token) {
                        return Response::errorResponse("User logged in failed.");
                    }
                    setcookie('refresh_token', $refreshToken, time() + 60 * 60 * 24 * 7, '/', '', false, true);
                }
                Auth::generateAccessToken($user['id']);
                return Response::successResponse("User logged in successfully.");
            }
            return Response::errorResponse("Invalid Credentials.");
        } catch (Throwable $error) {
            return Response::errorResponse($error->getMessage());
        }
    }
    private function validateUserData($userData)
    {
        $username = $userData['username'] ?? '';
        $email = $userData['email'] ?? '';
        $password = $userData['password'] ?? '';
        $confirmPassword = $userData['confirmPassword'] ?? '';

        Data::onlyAlphaNum("Username", $username, false, false);
        if (strlen($username)  < 4 || strlen($username) > 20) {
            throw new Exception("Username must be 4 to 20 characters long.");
        }
        Data::onlyAlphaNum("Email", $email);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email format.");
        }
        if ($password === '' || $password === null) {
            throw new Exception("Password is empty.");
        }
        if (strlen($password) < 8) {
            throw new Exception("Password must be at least 8 characters long.");
        }
        if ($confirmPassword === '' || $confirmPassword === null) {
            throw new Exception("Confirm Password is empty.");
        }
        if ($password !== $confirmPassword) {
            throw new Exception("Password does not match.");
        }
    }
    private function isUsernameExists($username)
    {
        $user = $this->userModel->getUserByUsername($username);
        if ($user) {
            throw new Exception("Username already exists.");
        }
    }
    private function isEmailExists($email)
    {
        $user = $this->userModel->getUserByEmail($email);
        if ($user) {
            throw new Exception("Email already exists.");
        }
    }
}
