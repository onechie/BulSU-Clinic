<?php
include_once("../utils/utility.php");
include_once("../database/database.php");
include_once("../model/complaint.php");
include_once("../model/laboratory.php");
include_once("../model/treatment.php");
include_once("../model/storage.php");
include_once("../controller/settings.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['route'])) {

    $complaint = new ComplaintModel();
    $laboratory = new LaboratoryModel();
    $treatment = new TreatmentModel();
    $storage = new StorageModel();

    $settingsController = new SettingsController($complaint, $laboratory, $treatment, $storage);

    if ($_GET['route'] === "getComplaints") {

        $response = $settingsController->getComplaints();

        header('Content-Type: application/json');
        echo json_encode($response);
    }
    if ($_GET['route'] === "getTreatments") {

        $response = $settingsController->getTreatments();

        header('Content-Type: application/json');
        echo json_encode($response);
    }
    if ($_GET['route'] === "getLaboratories") {

        $response = $settingsController->getLaboratories();

        header('Content-Type: application/json');
        echo json_encode($response);
    }
    if ($_GET['route'] === "getStorages") {

        $response = $settingsController->getStorages();

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['route'])) {

    $complaint = new ComplaintModel();
    $laboratory = new LaboratoryModel();
    $treatment = new TreatmentModel();
    $storage = new StorageModel();


    $settingsController = new SettingsController($complaint, $laboratory, $treatment, $storage);

    if ($_POST['route'] === "addComplaint") {

        $response = $settingsController->addComplaint($_POST['description']);

        header('Content-Type: application/json');
        echo json_encode($response);
    }
    if ($_POST['route'] === "deleteComplaint") {
        $response = $settingsController->deleteComplaint($_POST['id']);

        header('Content-Type: application/json');
        echo json_encode($response);
    }
    if ($_POST['route'] === "addTreatment") {

        $response = $settingsController->addTreatment($_POST['description']);

        header('Content-Type: application/json');
        echo json_encode($response);
    }
    if ($_POST['route'] === "deleteTreatment") {
        $response = $settingsController->deleteTreatment($_POST['id']);

        header('Content-Type: application/json');
        echo json_encode($response);
    }
    if ($_POST['route'] === "addLaboratory") {

        $response = $settingsController->addLaboratory($_POST['description']);

        header('Content-Type: application/json');
        echo json_encode($response);
    }
    if ($_POST['route'] === "deleteLaboratory") {
        $response = $settingsController->deleteLaboratory($_POST['id']);

        header('Content-Type: application/json');
        echo json_encode($response);
    }
    if ($_POST['route'] === "addStorage") {

        $response = $settingsController->addStorage($_POST['description']);

        header('Content-Type: application/json');
        echo json_encode($response);
    }
    if ($_POST['route'] === "deleteStorage") {
        $response = $settingsController->deleteStorage($_POST['id']);

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
