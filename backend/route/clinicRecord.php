<?php
include_once("../database/database.php");
include_once("../model/record.php");
include_once("../model/attachment.php");
include_once("../controller/clinicRecord.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['route'])) {

    $recordModel = new RecordModel();
    $attachmentModel = new AttachmentModel();
    $clinicRecordController = new ClinicRecordController($recordModel, $attachmentModel);

    if ($_GET['route'] == "getAllRecords") {


        $response = $clinicRecordController->getAllRecords();

        header('Content-Type: application/json');
        echo json_encode($response);
    }
    if ($_GET['route'] == "getRecordsByName") {

        $response = $clinicRecordController->getRecordsByName($_GET['name']);

        header('Content-Type: application/json');
        echo json_encode($response);
    }
    if ($_GET['route'] == "getRecordById") {

        $response = $clinicRecordController->getRecordById($_GET['id']);

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['route'])) {

    $recordModel = new RecordModel();
    $attachmentModel = new AttachmentModel();
    $clinicRecordController = new ClinicRecordController($recordModel, $attachmentModel);

   
    if ($_POST['route'] == "addAttachment") {

        $response = $clinicRecordController->addAttachment($_POST, $_FILES['attachments']);

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
