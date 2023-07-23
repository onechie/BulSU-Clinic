<?php
include_once("../utils/utility.php");
include_once("../database/database.php");
include_once("../model/medicine.php");
include_once("../model/storage.php");
include_once("../controller/inventory.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['route'])) {

    $medicineModel = new MedicineModel();
    $storageModel = new StorageModel();
    $inventoryController = new InventoryController($medicineModel, $storageModel);

    if ($_POST['route'] == "createMedicine") {
        $response = $inventoryController->createMedicine($_POST);

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['route'])) {

    $medicineModel = new MedicineModel();
    $storageModel = new StorageModel();
    $inventoryController = new InventoryController($medicineModel, $storageModel);

    if ($_GET['route'] == "getFormSuggestions") {
        $response = $inventoryController->getFormSuggestions();

        header('Content-Type: application/json');
        echo json_encode($response);
    }
    
    if ($_GET['route'] == "getAllMedicine") {
        $response = $inventoryController->getAllMedicine();

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
