<?php
include_once("../database/database.php");
include_once("../model/medicine.model.php");
include_once("../controller/inventory.controller.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the form was submitted for creating a medicine
    if ($_POST['requestType'] == "createMedicine") {
        // Get the data from $_POST
        $name = $_POST['name'];
        $brand = $_POST['brand'];
        $unit = $_POST['unit'];
        $expiration = $_POST['expiration'];
        $boxesC = $_POST['boxesCount'];
        $itemsC = $_POST['itemsCount'];

        // Create an associative array with the medicine data
        $medicineData = array(
            'name' => $name,
            'brand' => $brand,
            'unit' => $unit,
            'expiration' => $expiration,
            'boxesC' => $boxesC,
            'itemsC' => $itemsC
        );

        // Create an instance of the MedicineModel
        $medicineModel = new MedicineModel();

        // Create an instance of the InventoryController and pass the MedicineModel as a dependency
        $ic = new InventoryController($medicineModel);

        // Call the createMedicine method in the InventoryController and pass the $medicineData array
        $response = $ic->createMedicine($medicineData);

        // Encode the response as JSON and echo it
        echo json_encode($response);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($_GET['requestType'] == "getAllMedicine") {
        // Create an instance of the MedicineModel
        $medicineModel = new MedicineModel();

        // Create an instance of the InventoryController and pass the MedicineModel as a dependency
        $inventoryController = new InventoryController($medicineModel);

        // Call the getAllMedicine method in the InventoryController
        $response = $inventoryController->getAllMedicine();

        // Encode the response as JSON and echo it
        echo json_encode($response);
    }
}
