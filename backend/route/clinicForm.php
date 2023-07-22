<?php
include_once("../utils/utility.php");
include_once("../database/database.php");
include_once("../model/record.php");
include_once("../model/attachment.php");
include_once("../model/complaint.php");
include_once("../model/medicine.php");
include_once("../model/treatment.php");
include_once("../model/laboratory.php");
include_once("../controller/clinicForm.php");


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['route'])) {

    $recordModel = new RecordModel();
    $attachmentModel = new AttachmentModel();
    $complaintModel = new ComplaintModel();
    $medicineModel = new MedicineModel();
    $treatmentModel = new TreatmentModel();
    $laboratoryModel = new LaboratoryModel();
    $clinicFormController = new ClinicFormController($recordModel, $attachmentModel, $complaintModel, $medicineModel, $treatmentModel, $laboratoryModel);

    if ($_POST['route'] == "createRecord") {

        $fileData = isset($_FILES["attachments"]) ? $_FILES["attachments"] : [];
        $response = $clinicFormController->createRecord($_POST, $fileData);

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['route'])) {

    $recordModel = new RecordModel();
    $attachmentModel = new AttachmentModel();
    $complaintModel = new ComplaintModel();
    $medicineModel = new MedicineModel();
    $treatmentModel = new TreatmentModel();
    $laboratoryModel = new LaboratoryModel();
    $clinicFormController = new ClinicFormController($recordModel, $attachmentModel, $complaintModel, $medicineModel, $treatmentModel, $laboratoryModel);
    if ($_GET['route'] == "getFormSuggestions") {
        $response = $clinicFormController->getFormSuggestions();

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
