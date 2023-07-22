<?php
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
            // Password matches, user is logged in successfully
            // Additional actions after successful login
            // ...
            return $this->successResponse("User logged in successfully.");
        } else {
            return $this->errorResponse("Invalid password.");
        }
    }
}
