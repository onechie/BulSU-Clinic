<?php 
$storagesController = new StoragesController(new StorageModel);

$router->get('/storages', function () use ($storagesController) {
    if (isset($_GET['id'])) {
        return $storagesController->getStorage($_GET);
    } else {
        return $storagesController->getStorages();
    }
}, true);
$router->post('/storages', function () use ($storagesController) {
    return $storagesController->addStorage($_POST);
}, true);
$router->post('/storages/update', function () use ($storagesController) {
    return $storagesController->updateStorage($_POST);
}, true);
$router->post('/storages/delete', function () use ($storagesController) {
    return $storagesController->deleteStorage($_POST);
}, true); 