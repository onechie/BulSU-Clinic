<?php
$medicineModel = new MedicineModel();
$storageModel = new StorageModel();
$inventoryController = new InventoryController($medicineModel, $storageModel);

$router = new ApiRouter($inventoryController);

//GET REQUESTS
$router->get("getFormSuggestions", function ($controller) {
    $response = $controller->getFormSuggestions();
    return $response;
});
$router->get("getAllMedicine", function ($controller) {
    $response = $controller->getAllMedicine();
    return $response;
});

//POST REQUESTS
$router->post("createMedicine", function ($controller) {
    $response = $controller->createMedicine($_POST);
    return $response;
});

$router->run();
