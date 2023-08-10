<?php
// SET HEADERS
header('Content-Type: application/json');

// GENERAL
require_once '../../vendor/autoload.php';
require_once '../database/database.php';
require_once '../database/tablesInitializer.php';
require_once 'router.php';

// MIDDLEWARE
require_once '../middleware/middleware.php';
// MODEL
require_once '../model/model.php';
// CONTROLLER
require_once '../controller/controller.php';

// MODEL INSTANCES
$userModel = new UserModel();
$medicineModel = new MedicineModel();
$recordModel = new RecordModel();
$attachmentModel = new AttachmentModel();
$complaintModel = new ComplaintModel();
$laboratoryModel = new LaboratoryModel();
$storageModel = new StorageModel();
$treatmentModel = new TreatmentModel();

// ROUTER INSTANCE
$router = new Router();

// ROUTES
require_once 'routes/routes.php';

// Handle 404 Not Found
$router->set404(function () {
    echo json_encode(Response::errorResponse("Endpoint Not Found.", 404));
});

// Run the router
$router->run();
