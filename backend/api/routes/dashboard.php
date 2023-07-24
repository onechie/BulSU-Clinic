<?php
$medicineModel = new MedicineModel();
$dashboardController =  new DashboardController($medicineModel);

$router = new ApiRouter($dashboardController);

//GET REQUESTS
$router->get("getAllMedicine", function ($controller) {
    $response = $controller->getAllMedicine();
    return $response;
});

//POST REQUESTS

$router->run();
