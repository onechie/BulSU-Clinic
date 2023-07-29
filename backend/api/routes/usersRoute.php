<?php
$usersController = new UsersController($userModel);

$router->post('/users/login', function () use ($usersController) {
    return $usersController->loginUser($_POST);
});

$router->post('/users/register', function () use ($usersController) {
    return $usersController->registerUser($_POST);
});
