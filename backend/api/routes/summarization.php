<?php
$medicineModel = new MedicineModel();
$summarizationController = new summarizationController($medicineModel);

$router = new ApiRouter($summarizationController);

//GET REQUESTS
$router->get("getMedicines", function ($controller) {
    $response = $controller->getMedicines();
    return $response;
});
//POST REQUESTS

$router->run();
