<?php
$logsController = new LogsController($logModel);

$router->get('/logs', function () use ($logsController) {
    if (isset($_GET['id'])) {
        return $logsController->getLog($_GET);
    } else {
        return $logsController->getLogs();
    }
}, true);
$router->post('/logs', function () use ($logsController) {
    return $logsController->addLog($_POST);
}, true);
