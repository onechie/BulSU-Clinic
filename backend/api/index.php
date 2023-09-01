<?php
// SET HEADERs
header('Content-Type: application/json');

// GENERAL
require_once '../../vendor/autoload.php';
require_once '../database/database.php';
require_once '../database/tablesInitializer.php';
require_once 'router.php';

// MIDDLEWAREs
require_once '../middleware/middleware.php';
// MODELs
require_once '../model/model.php';
// CONTROLLERs
require_once '../controller/controller.php';

// MODEL INSTANCEs
$userModel = new UserModel();
$medicineModel = new MedicineModel();
$recordModel = new RecordModel();
$attachmentModel = new AttachmentModel();
$complaintModel = new ComplaintModel();
$laboratoryModel = new LaboratoryModel();
$storageModel = new StorageModel();
$treatmentModel = new TreatmentModel();
$logModel = new LogModel();

// ROUTER INSTANCE
$router = new Router();

// ROUTEs
require_once 'routes/routes.php';

// Handle 404 Not Found
$router->set404(function () {
    echo json_encode(Response::errorResponse("Endpoint Not Found.", 404));
});

// Run the router
$router->run();
