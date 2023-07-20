<?php
include_once("../database/database.php");
include_once("../model/record.model.php");
include_once("../controller/clinicRecord.controller.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($_GET['requestType'] === "getAllRecord") {
        // Create an instance of the RecordModel
        $recordModel = new RecordModel();

        // Create an instance of the ClinicRecordController and pass the RecordModel as a dependency
        $clinicRecordController = new ClinicRecordController($recordModel);

        // Call the getAllRecord method in the ClinicRecordController
        $response = $clinicRecordController->getAllRecord();

        // Encode the response as JSON and echo it
        echo json_encode($response);
    }
    if ($_GET['requestType'] === "getAllRecordByName") {
        // Create an instance of the RecordModel
        $recordModel = new RecordModel();

        // Create an instance of the ClinicRecordController and pass the RecordModel as a dependency
        $clinicRecordController = new ClinicRecordController($recordModel);

        // Call the getAllRecord method in the ClinicRecordController
        $response = $clinicRecordController->getAllRecordByName($_GET['name']);

        // Encode the response as JSON and echo it
        echo json_encode($response);
    }
    if ($_GET['requestType'] === "getRecordById") {
        // Create an instance of the RecordModel
        $recordModel = new RecordModel();

        // Create an instance of the ClinicRecordController and pass the RecordModel as a dependency
        $clinicRecordController = new ClinicRecordController($recordModel);

        // Call the getRecordById method in the ClinicRecordController
        $response = $clinicRecordController->getRecordById($_GET['id']);

        // Encode the response as JSON and echo it
        echo json_encode($response);
    }
}
