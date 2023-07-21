<?php
include_once("../database/database.php");
include_once("../model/medicine.php");
include_once("../controller/inventory.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['route'])) {

    if ($_POST['route'] == "createMedicine") {

        $medicineModel = new MedicineModel();
        $ic = new InventoryController($medicineModel);
        $response = $ic->createMedicine($_POST);

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['route'])) {

    if ($_GET['route'] == "getAllMedicine") {

        $medicineModel = new MedicineModel();
        $inventoryController = new InventoryController($medicineModel);
        $response = $inventoryController->getAllMedicine();

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
