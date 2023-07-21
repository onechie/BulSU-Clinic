<?php
include_once("../database/database.php");
include_once("../model/user.php");
include_once("../controller/login.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['route'])) {

    if ($_GET['route'] === "login") {

        $userModel = new UserModel();
        $loginController = new LoginController($userModel);
        $response = $loginController->loginUser($_GET);

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
