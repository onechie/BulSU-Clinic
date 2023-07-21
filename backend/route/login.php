<?php
include_once("../database/database.php");
include_once("../model/user.php");
include_once("../controller/login.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['route'])) {

    $userModel = new UserModel();
    $loginController = new LoginController($userModel);

    if ($_GET['route'] === "login") {

        $response = $loginController->loginUser($_GET);

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
