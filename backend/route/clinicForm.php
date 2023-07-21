<?php
include_once("../database/database.php");
include_once("../model/record.php");
include_once("../model/attachment.php");
include_once("../controller/clinicForm.php");


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['route'])) {

    if ($_POST['route'] == "createRecord") {

        $fileData = isset($_FILES["attachments"]) ? $_FILES["attachments"] : [];
        $recordModel = new RecordModel();
        $attachmentModel = new AttachmentModel();
        $clinicFormController = new ClinicFormController($recordModel, $attachmentModel);
        $response = $clinicFormController->createRecord($_POST, $fileData);

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}