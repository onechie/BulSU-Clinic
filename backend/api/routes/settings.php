<?php
$complaint = new ComplaintModel();
$laboratory = new LaboratoryModel();
$treatment = new TreatmentModel();
$storage = new StorageModel();
$settingsController = new SettingsController($complaint, $laboratory, $treatment, $storage);

$router = new ApiRouter($settingsController);

//GET REQUESTS
$router->get("getComplaints", function ($controller) {
    $response = $controller->getComplaints();
    return $response;
});
$router->get("getTreatments", function ($controller) {
    $response = $controller->getTreatments();
    return $response;
});
$router->get("getLaboratories", function ($controller) {
    $response = $controller->getLaboratories();
    return $response;
});
$router->get("getStorages", function ($controller) {
    $response = $controller->getStorages();
    return $response;
});

//POST REQUESTS
$router->post("addComplaint", function ($controller) {
    $response = $controller->addComplaint($_POST['description']);
    return $response;
});
$router->post("deleteComplaint", function ($controller) {
    $response = $controller->deleteComplaint($_POST['id']);
    return $response;
});
$router->post("addTreatment", function ($controller) {
    $response = $controller->addTreatment($_POST['description']);
    return $response;
});
$router->post("deleteTreatment", function ($controller) {
    $response = $controller->deleteTreatment($_POST['id']);
    return $response;
});
$router->post("addLaboratory", function ($controller) {
    $response = $controller->addLaboratory($_POST['description']);
    return $response;
});
$router->post("deleteLaboratory", function ($controller) {
    $response = $controller->deleteLaboratory($_POST['id']);
    return $response;
});
$router->post("addStorage", function ($controller) {
    $response = $controller->addStorage($_POST['description']);
    return $response;
});
$router->post("deleteStorage", function ($controller) {
    $response = $controller->deleteStorage($_POST['id']);
    return $response;
});

$router->run();
