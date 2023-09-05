<?php
$usersController = new UsersController($userModel, $profileModel);

$router->get('/users/me', function () use ($usersController) {
    return $usersController->getUser();
}, true);

$router->get('/users/auth', function () use ($usersController) {
    return $usersController->authenticateUser();
});

$router->post('/users/login', function () use ($usersController) {
    return $usersController->loginUser($_POST);
});
$router->get('/users/logout', function () use ($usersController) {
    return $usersController->logoutUser();
}, true);

$router->post('/users/register', function () use ($usersController) {
    return $usersController->registerUser($_POST, $_FILES);
});
$router->post('/users/password/change', function () use ($usersController) {
    return $usersController->changePassword($_POST);
}, true);
