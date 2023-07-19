<?php
include_once("../database/database.php");
include_once("../model/user.model.php");
include_once("../controller/login.controller.php");

if($_GET['requestType'] == "login"){
    // Get the necessary data from the POST request
    $usernameOrEmail = $_GET['usernameOrEmail'];
    $password = $_GET['password'];

    // Create an associative array with the login data
    $loginUser = array(
        'usernameOrEmail' => $usernameOrEmail,
        'password' => $password
    );

    // Create an instance of UserModel (assuming you have UserModel class)
    $userModel = new UserModel();

    // Create an instance of LoginController and pass the UserModel instance
    $loginController = new LoginController($userModel);

    // Perform the login operation and get the response
    $response = $loginController->loginUser($loginUser);

    // Output the response as JSON
    echo json_encode($response);
}