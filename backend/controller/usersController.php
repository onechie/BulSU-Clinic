<?php
// Check if the file is being directly accessed via URL
require_once("../utils/utility.php");
Utility::preventDirectAccess();
class UsersController extends Utility
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
        $expectedKeys = ['username', 'email', 'password', 'confirmPassword'];
        $req = $this->filterData($req, $expectedKeys);
        try {
            $this->validateUserData($req);
            $this->isUsernameExists($req['username']);
            $this->isEmailExists($req['username']);
            $req['password'] = password_hash($req['password'], PASSWORD_DEFAULT);
            $result = $this->userModel->addUser(...array_values($req));
            if ($result) {
                return $this->successResponse($req['username'] . " registered successfully.");
            } else {
                return $this->errorResponse("User registration failed.");
            }
        } catch (Throwable $error) {
            return $this->errorResponse($error->getMessage());
        }
    }
    public function loginUser($req)
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        $expectedKeys = ['usernameOrEmail', 'password', 'keepLoggedIn', 'X-CSRF-TOKEN'];
        $req = $this->filterData($req, $expectedKeys);
        try {
            $this->onlyAlphaNum("Username or email", $req['usernameOrEmail'] ?? null);
            if (!$req['password']) {
                return $this->errorResponse("Password is empty.");
            }
            $user = $this->userModel->getUserByEmail($req['usernameOrEmail']);
            if (!$user) {
                $user = $this->userModel->getUserByUsername($req['usernameOrEmail']);
            }
            if (!$user) {
                return $this->errorResponse("Invalid Credentials.");
            }
            if (password_verify($req['password'], $user['password'])) {
                echo json_encode($req);
                if (filter_var($req['keepLoggedIn'], FILTER_VALIDATE_BOOLEAN)) {
                    $refreshToken = $this->generateRefreshToken();
                    $token = $this->tokenModel->addToken($refreshToken, $user['id'], date('Y-m-d', strtotime('+1 week')));
                    if (!$token) {
                        return $this->errorResponse("User logged in failed.");
                    }
                    setcookie('refresh_token', $refreshToken, time() + 60 * 60 * 24 * 7, '/', '', false, true);
                }
                $this->generateAccessToken($user['id']);
                return $this->successResponse("User logged in successfully.");
            }
            return $this->errorResponse("Invalid Credentials.");
        } catch (Throwable $error) {
            return $this->errorResponse($error->getMessage());
        }
    }
    private function validateUserData($userData)
    {
        $username = $userData['username'] ?? '';
        $email = $userData['email'] ?? '';
        $password = $userData['password'] ?? '';
        $confirmPassword = $userData['confirmPassword'] ?? '';

        $this->onlyAlphaNum("Username", $username, false, false);
        if (strlen($username)  < 4 || strlen($username) > 20) {
            throw new Exception("Username must be 4 to 20 characters long.");
        }
        $this->onlyAlphaNum("Email", $email);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email format.");
        }
        if (strlen($password) < 8) {
            throw new Exception("Password must be at least 8 characters long.");
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

    private function generateCSRFToken()
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
