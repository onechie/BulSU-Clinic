<?php
include_once("../database/database.php");
include_once("../model/record.php");
include_once("../controller/clinicRecord.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['route'])) {

    if ($_GET['route'] == "getAllRecords") {

        $recordModel = new RecordModel();
        $clinicRecordController = new ClinicRecordController($recordModel);
        $response = $clinicRecordController->getAllRecords();

        header('Content-Type: application/json');
        echo json_encode($response);
    }
    if ($_GET['route'] == "getRecordsByName") {

        $recordModel = new RecordModel();
        $clinicRecordController = new ClinicRecordController($recordModel);
        $response = $clinicRecordController->getRecordsByName($_GET['name']);

        header('Content-Type: application/json');
        echo json_encode($response);
    }
    if ($_GET['route'] == "getRecordById") {

        $recordModel = new RecordModel();
        $clinicRecordController = new ClinicRecordController($recordModel);
        $response = $clinicRecordController->getRecordById($_GET['id']);

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
