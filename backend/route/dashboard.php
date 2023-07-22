<?php
include_once("../database/database.php");
include_once("../model/medicine.php");
include_once("../controller/dashboard.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['route'])) {

    $medicineModel = new MedicineModel();
    $dashboardController = new DashboardController($medicineModel);

    if ($_GET['route'] == "getAllMedicine") {
        $response = $dashboardController->getAllMedicine();

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
