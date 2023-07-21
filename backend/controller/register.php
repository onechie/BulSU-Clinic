<?php 
class RegisterController
{
    private $userModel;

    public function __construct(UserModel $userModel)
    {
        $this->userModel = $userModel;
    }

    public function registerUser(array $userData): array
    {

        $username = $userData['username'] ?? '';
        $email = $userData['email'] ?? '';
        $password = $userData['password'] ?? '';
        $confirmPassword = $userData['confirmPassword'] ?? '';

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->errorResponse("Invalid email format.");
        }

        if ($password !== $confirmPassword) {
            return $this->errorResponse("Password and confirm password do not match.");
        }

        if (empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
            return $this->errorResponse("Username, email, password, and confirm password are required.");
        }

        $userExists = $this->userModel->findUserByUsernameOrEmail($username, $email);

        if ($userExists) {
            return $this->errorResponse("Username or email is already taken.");
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        if ($this->userModel->createUserRecord($username, $email, $hashedPassword)) {
            return $this->successResponse("User registered successfully.");
        } else {
            return $this->errorResponse("Internal Error: Unable to register user.");
        }
    }

    private function successResponse(string $message): array
    {
        return ['success' => true, 'message' => $message];
    }

    private function errorResponse(string $message): array
    {
        return ['success' => false, 'message' => $message];
    }
}
