<?php
include_once "./backendRouter.php";
include_once("../database/database.php");
include_once("../model/medicine.php");
include_once("../controller/summarization.php");

$medicineModel = new MedicineModel();
$summarizationController = new summarizationController($medicineModel);

$router = new BackendRouter($summarizationController);

//GET REQUESTS
$router->get("getMedicines", function ($controller) {
    $response = $controller->getMedicines();
    return $response;
});
//POST REQUESTS

$router->run();
