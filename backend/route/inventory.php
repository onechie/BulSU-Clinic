<?php
include_once("../utils/utility.php");
include_once("../database/database.php");
include_once("../model/medicine.php");
include_once("../controller/inventory.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['route'])) {

    $medicineModel = new MedicineModel();
    $ic = new InventoryController($medicineModel);

    if ($_POST['route'] == "createMedicine") {
        $response = $ic->createMedicine($_POST);

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['route'])) {

    $medicineModel = new MedicineModel();
    $inventoryController = new InventoryController($medicineModel);

    if ($_GET['route'] == "getAllMedicine") {
        $response = $inventoryController->getAllMedicine();

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
