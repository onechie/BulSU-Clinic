<?php
include_once "./backendRouter.php";
include_once("../database/database.php");
include_once("../model/record.php");
include_once("../model/attachment.php");
include_once("../controller/clinicRecord.php");

$recordModel = new RecordModel();
$attachmentModel = new AttachmentModel();
$clinicRecordController = new ClinicRecordController($recordModel, $attachmentModel);

$router = new BackendRouter($clinicRecordController);

//GET REQUESTS
$router->get("getAllRecords", function ($controller) {
    $response = $controller->getAllRecords;
    return $response;
});
$router->get("getRecordsByName", function ($controller) {
    $response = $controller->getRecordsByName($_GET['name']);
    return $response;
});
$router->get("getRecordById", function ($controller) {
    $response = $controller->getRecordById($_GET['id']);
    return $response;
});

//POST REQUESTS
$router->post("addAttachment", function ($controller) {
    $fileData = isset($_FILES["attachments"]) ? $_FILES["attachments"] : [];
    $response = $controller->addAttachment($_POST, $fileData);
    return $response;
});

$router->run();
