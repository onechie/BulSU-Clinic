<?php
$tokensController = new TokensController($tokenModel);

$router->get('/token/refresh', function () use ($tokensController) {
    return $tokensController->refreshAuthToken();
});
