<?php
include_once "./backendRouter.php";
include_once("../database/database.php");
include_once("../model/medicine.php");
include_once("../controller/dashboard.php");

$medicineModel = new MedicineModel();
$dashboardController =  new DashboardController($medicineModel);

$router = new BackendRouter($dashboardController);

//GET REQUESTS
$router->get("getAllMedicine", function ($controller) {
    $response = $controller->getAllMedicine();
    return $response;
});

//POST REQUESTS

$router->run();
