<?php
include_once("../utils/utility.php");
include_once("../database/database.php");
include_once("../model/complaint.php");
include_once("../model/laboratory.php");
include_once("../model/treatment.php");
include_once("../controller/settings.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['route'])) {

    $complaint = new ComplaintModel();
    $laboratory = new LaboratoryModel();
    $treatment = new TreatmentModel();

    $settingsController = new SettingsController($complaint, $laboratory, $treatment);

    if ($_GET['route'] === "getComplaints") {
        
        $response = $settingsController->getComplaints();

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['route'])) {

    $complaint = new ComplaintModel();
    $laboratory = new LaboratoryModel();
    $treatment = new TreatmentModel();

    $settingsController = new SettingsController($complaint, $laboratory, $treatment);

    if ($_POST['route'] === "addComplaint") {
        
        $response = $settingsController->addComplaint($_POST['description']);

        header('Content-Type: application/json');
        echo json_encode($response);
    }
    if ($_POST['route'] === "deleteComplaint"){
        $response = $settingsController->deleteComplaint($_POST['id']);

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
