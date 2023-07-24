<?php
$recordModel = new RecordModel();
$attachmentModel = new AttachmentModel();
$complaintModel = new ComplaintModel();
$medicineModel = new MedicineModel();
$treatmentModel = new TreatmentModel();
$laboratoryModel = new LaboratoryModel();
$clinicFormController =  new ClinicFormController($recordModel, $attachmentModel, $complaintModel, $medicineModel, $treatmentModel, $laboratoryModel);

$router = new ApiRouter($clinicFormController);

//GET REQUESTS
$router->get("getFormSuggestions", function ($controller) {
    $response = $controller->getFormSuggestions();
    return $response;
});

//POST REQUESTS
$router->post("createRecord", function ($controller) {
    $fileData = isset($_FILES["attachments"]) ? $_FILES["attachments"] : [];
    $response = $controller->createRecord($_POST, $fileData);
    return $response;
});

$router->run();