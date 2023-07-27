<?php 
$storageModel = new StorageModel();
$storagesController = new StoragesController($storageModel);

$router->get('/storages', function () use ($storagesController) {
    if (isset($_GET['id'])) {
        return $storagesController->getStorage($_GET);
    } else {
        return $storagesController->getStorages();
    }
});
$router->post('/storages', function () use ($storagesController) {
    return $storagesController->addStorage($_POST);
});
$router->post('/storages/update', function () use ($storagesController) {
    return $storagesController->updateStorage($_POST);
});
$router->post('/storages/delete', function () use ($storagesController) {
    return $storagesController->deleteStorage($_POST);
}); 