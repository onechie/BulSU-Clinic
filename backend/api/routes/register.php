<?php
$userModel = new UserModel();
$registerController =  new RegisterController($userModel);

$router = new ApiRouter($registerController);

//GET REQUESTS

//POST REQUESTS
$router->post("register", function ($controller) {
    $response = $controller->registerUser($_POST);
    sleep(2);
    return $response;
});

$router->run();
