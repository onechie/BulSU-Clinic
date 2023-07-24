<?php
// GENERAL
require_once '../utils/Utility.php';
require_once '../database/database.php';
require_once 'path_router.php';
require_once 'api_router.php';

// MODELS
require_once '../model/attachment.php';
require_once '../model/complaint.php';
require_once '../model/laboratory.php';
require_once '../model/medicine.php';
require_once '../model/record.php';
require_once '../model/storage.php';
require_once '../model/treatment.php';
require_once '../model/user.php';

// CONTROLLERS
require_once '../controller/clinicForm.php';
require_once '../controller/clinicRecord.php';
require_once '../controller/dashboard.php';
require_once '../controller/inventory.php';
require_once '../controller/login.php';
require_once '../controller/register.php';
require_once '../controller/settings.php';
require_once '../controller/summarization.php';

// SET HEADERS
header('Content-Type: application/json');

$pathRouter = new PathRouter();

// ROUTES
$pathRouter->route('/login', function () {
    PathRouter::requireFile('login.php');
});

$pathRouter->route('/register', function () {
    PathRouter::requireFile('register.php');
});

$pathRouter->route('/dashboard', function () {
    PathRouter::requireFile('dashboard.php');
});

$pathRouter->route('/inventory', function () {
    PathRouter::requireFile('inventory.php');
});

$pathRouter->route('/summarization', function () {
    PathRouter::requireFile('summarization.php');
});

$pathRouter->route('/clinicForm', function () {
    PathRouter::requireFile('clinicForm.php');
});

$pathRouter->route('/clinicRecord', function () {
    PathRouter::requireFile('clinicRecord.php');
});

$pathRouter->route('/settings', function () {
    PathRouter::requireFile('settings.php');
});

// Handle 404 Not Found
$pathRouter->set404(function () {
    http_response_code(404);
    $response = [
        "message" => "Route Not Found"
    ];
    echo json_encode($response);
});

// Run the router
$pathRouter->run();
