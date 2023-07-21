<?php
include_once("../database/database.php");
include_once("../model/record.php");
include_once("../model/attachment.php");
include_once("../controller/clinicForm.php");


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['route'])) {

    $recordModel = new RecordModel();
    $attachmentModel = new AttachmentModel();
    $clinicFormController = new ClinicFormController($recordModel, $attachmentModel);

    if ($_POST['route'] == "createRecord") {

        $fileData = isset($_FILES["attachments"]) ? $_FILES["attachments"] : [];
        $response = $clinicFormController->createRecord($_POST, $fileData);

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
