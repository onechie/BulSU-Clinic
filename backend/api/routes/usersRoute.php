<?php
$usersController = new UsersController($userModel);

$router->get('/users/auth', function () use ($usersController) {
    return $usersController->authenticateUser($_GET);
});

$router->post('/users/login', function () use ($usersController) {
    return $usersController->loginUser($_POST);
});

$router->post('/users/register', function () use ($usersController) {
    return $usersController->registerUser($_POST);
});
