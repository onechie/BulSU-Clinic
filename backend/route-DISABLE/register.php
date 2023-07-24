<?php
include_once "./backendRouter.php";
include_once("../database/database.php");
include_once("../model/user.php");
include_once("../controller/register.php");

$userModel = new UserModel();
$registerController =  new RegisterController($userModel);

$router = new BackendRouter($registerController);

//GET REQUESTS

//POST REQUESTS
$router->post("register", function ($controller) {
    $response = $controller->registerUser($_POST);
    return $response;
});

$router->run();
