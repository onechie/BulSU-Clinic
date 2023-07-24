<?php
include_once "./backendRouter.php";
include_once("../database/database.php");
include_once("../model/record.php");
include_once("../model/attachment.php");
include_once("../model/complaint.php");
include_once("../model/medicine.php");
include_once("../model/treatment.php");
include_once("../model/laboratory.php");
include_once("../controller/clinicForm.php");

$recordModel = new RecordModel();
$attachmentModel = new AttachmentModel();
$complaintModel = new ComplaintModel();
$medicineModel = new MedicineModel();
$treatmentModel = new TreatmentModel();
$laboratoryModel = new LaboratoryModel();
$clinicFormController =  new ClinicFormController($recordModel, $attachmentModel, $complaintModel, $medicineModel, $treatmentModel, $laboratoryModel);

$router = new BackendRouter($clinicFormController);

//GET REQUESTS
$router->get("getFormSuggestions", function ($controller) {
    $response = $controller->getFormSuggestions();
    return $response;
});

//POST REQUESTS
$router->post("createRecord", function ($controller) {
    $fileData = isset($_FILES["attachments"]) ?? [];
    $response = $controller->createRecord($_POST, $fileData);
    return $response;
});

$router->run();
