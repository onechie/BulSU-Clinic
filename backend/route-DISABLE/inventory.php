<?php
include_once "./backendRouter.php";
include_once("../database/database.php");
include_once("../model/medicine.php");
include_once("../model/storage.php");
include_once("../controller/inventory.php");

$medicineModel = new MedicineModel();
$storageModel = new StorageModel();
$inventoryController = new InventoryController($medicineModel, $storageModel);

$router = new BackendRouter($inventoryController);

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
