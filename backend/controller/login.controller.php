<?php
class LoginController
{
    private $userModel;

    public function __construct(UserModel $userModel)
    {
        $this->userModel = $userModel;
    }
    public function loginUser($loginUser)
    {
        // Get the necessary data from the $loginUser array
        $usernameOrEmail = $loginUser['usernameOrEmail'];
        $password = $loginUser['password'];

        // Initialize the response array
        $response = [];

        // Validate username/email and password
        if (empty($usernameOrEmail) || empty($password)) {
            $response['success'] = false;
            $response['message'] = "Username/Email and password are required.";
            return $response;
        }

        // Call the UserModel's getUser method to retrieve the user by username/email
        $user = $this->userModel->getUser($usernameOrEmail, $usernameOrEmail);

        if (!$user) {
            $response['success'] = false;
            $response['message'] = "User is not registered.";
            return $response;
        }

        // Verify the password
        $hashedPassword = $user['password'];
        if (password_verify($password, $hashedPassword)) {
            // Password matches, user is logged in successfully
            $response['success'] = true;
            $response['message'] = "User logged in successfully.";
            // Additional actions after successful login
            // ...
        } else {
            $response['success'] = false;
            $response['message'] = "Invalid password.";
        }

        return $response;
    }
}
