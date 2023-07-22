<?php
include_once("../utils/utility.php");
include_once("../database/database.php");
include_once("../model/user.php");
include_once("../controller/register.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['route'])) {

    $userModel = new UserModel();
    $registerController = new RegisterController($userModel);

    if ($_POST['route'] === "register") {
        
        $response = $registerController->registerUser($_POST);

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
