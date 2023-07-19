<?php
class RegisterController
{
    private $userModel;

    public function __construct(UserModel $userModel)
    {
        $this->userModel = $userModel;
    }
    public function registerUser($userData)
    {
        // Get the necessary data from the $userData array
        $username = $userData['username'];
        $email = $userData['email'];
        $password = $userData['password'];
        $confirmPassword = $userData['confirmPassword'];

        // Initialize the response array
        $response = [];

        // Validate username, email, and password

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $response['success'] = false;
            $response['message'] = "Invalid email format.";
            return $response;
        }

        if ($password !== $confirmPassword) {
            $response['success'] = false;
            $response['message'] = "Password and confirm password do not match.";
            return $response;
        }

        if (empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
            $response['success'] = false;
            $response['message'] = "Username, email, password, and confirm password are required.";
            return $response;
        }

        // Call the UserModel's getUser method to check if username or email is already used
        $userExists = $this->userModel->getUser($username, $email);

        if ($userExists) {
            $response['success'] = false;
            $response['message'] = "Username or email is already taken.";
            return $response;
        }

        // Hash the password for security
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Call the UserModel's setUser method for database insertion
        $result = $this->userModel->setUser($username, $email, $hashedPassword);

        // Set the response based on the result of the setUser method
        if ($result) {
            $response['success'] = true;
            $response['message'] = "User registered successfully.";
        } else {
            $response['success'] = false;
            $response['message'] = "Internal Error: Unable to register user.";
        }

        return $response;
    }
}
