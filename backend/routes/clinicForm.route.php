<?php
include_once("../database/database.php");
include_once("../model/record.model.php");
include_once("../model/attachment.model.php");
include_once("../controller/clinicForm.controller.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['requestType'] === "createRecord") {
    // Get the form data from $_POST
    $inputData = $_POST;

    // Check if $_FILES["attachments"] is set and not empty
    $fileData = isset($_FILES["attachments"]) ? $_FILES["attachments"] : [];

    // Create an instance of the RecordModel
    $recordModel = new RecordModel();

    // Create an instance of the AttachmentModel
    $attachmentModel = new AttachmentModel();

    // Create an instance of the ClinicFormController and pass the RecordModel and AttachmentModel as dependencies
    $clinicFormController = new ClinicFormController($recordModel, $attachmentModel);

    // Call the createRecord method in the ClinicFormController and pass the $formData array
    $response = $clinicFormController->createRecord($inputData, $fileData);

    // Encode the response as JSON and echo it
    echo json_encode($response);
}
