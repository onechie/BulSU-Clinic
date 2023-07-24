<?php
$userModel = new UserModel();
$loginController =  new LoginController($userModel);

$router = new ApiRouter($loginController);

//GET REQUESTS

//POST REQUESTS
$router->post("login", function ($controller) {
    $response = $controller->loginUser($_POST);
    return $response;
});

$router->run();
