<?php
include_once("../utils/utility.php");
include_once("../database/database.php");
include_once("../model/medicine.php");
include_once("../controller/summarization.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['route'])) {

    $medicineModel = new MedicineModel();
    $summarizationController = new summarizationController($medicineModel);

    if ($_GET['route'] == "getMedicines") {
        $response = $summarizationController->getMedicines();

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
