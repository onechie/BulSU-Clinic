<?php
include_once("../database/database.php");
include_once("../model/user.model.php");
include_once("../controller/register.controller.php");

// Check if the form was submitted for registration
if ($_POST['requestType'] == "register") {

    // Get the data from $_POST
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Create an associative array with the user data
    $userData = array(
        'username' => $username,
        'email' => $email,
        'password' => $password,
        'confirmPassword' => $confirmPassword
    );

    // Create an instance of the UserModel
    $userModel = new UserModel();

    // Create an instance of the RegisterController and pass the UserModel as a dependency
    $rc = new RegisterController($userModel);

    // Call the registerUser method in the RegisterController and pass the $userData array
    $response = $rc->registerUser($userData);

    // Encode the response as JSON and echo it
    echo json_encode($response);
}

