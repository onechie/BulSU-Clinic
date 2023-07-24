<?php
include_once "./backendRouter.php";
include_once("../database/database.php");
include_once("../model/user.php");
include_once("../controller/login.php");

$userModel = new UserModel();
$loginController =  new LoginController($userModel);

$router = new BackendRouter($loginController);

//GET REQUESTS

//POST REQUESTS
$router->post("login", function ($controller) {
    $response = $controller->loginUser($_POST);
    return $response;
});

$router->run();
