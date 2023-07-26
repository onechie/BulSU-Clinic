<?php
// Check if the file is being directly accessed via URL
require_once("../utils/utility.php");
Utility::preventDirectAccess();
class LoginController extends Utility
{
    private $userModel;

    public function __construct(UserModel $userModel)
    {
        $this->userModel = $userModel;
    }

    public function loginUser(array $loginData): array
    {
        $usernameOrEmail = $loginData['usernameOrEmail'] ?? '';
        $password = $loginData['password'] ?? '';

        if (empty($usernameOrEmail) || empty($password)) {
            return $this->errorResponse("Username/Email and password are required.");
        }

        $user = $this->userModel->findUserByUsernameOrEmail($usernameOrEmail, $usernameOrEmail);

        if (!$user) {
            return $this->errorResponse("User is not registered.");
        }

        $hashedPassword = $user['password'];
        if (password_verify($password, $hashedPassword)) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $token = $this->generateCSRFToken();
            $_SESSION['csrf_token'] = $token;
            // Password matches, user is logged in successfully
            // Additional actions after successful login
            // ...
            return $this->successResponse("User logged in successfully.");
        } else {
            return $this->errorResponse("Invalid password.");
        }
    }
    private function generateCSRFToken() {
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
