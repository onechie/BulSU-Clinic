<?php
// GENERAL
require_once '../utils/Utility.php';
require_once '../database/database.php';
require_once 'router.php';

// MODELS
require_once '../model/attachment.php';
require_once '../model/complaint.php';
require_once '../model/laboratory.php';
require_once '../model/medicine.php';
require_once '../model/record.php';
require_once '../model/storage.php';
require_once '../model/treatment.php';
require_once '../model/user.php';
require_once '../model/token.php';

// CONTROLLERS
require_once '../controller/medicinesController.php';
require_once '../controller/complaintsController.php';
require_once '../controller/laboratoriesController.php';
require_once '../controller/storagesController.php';
require_once '../controller/treatmentsController.php';
require_once '../controller/recordsController.php';
require_once '../controller/attachmentsController.php';
require_once '../controller/usersController.php';
require_once '../controller/tokensController.php';

// SET HEADERS
header('Content-Type: application/json');

// ROUTER INSTANCE
$router = new Router();

// MODEL INSTANCES
$medicineModel = new MedicineModel();
$complaintModel = new ComplaintModel();
$laboratoryModel = new LaboratoryModel();
$storageModel = new StorageModel();
$treatmentModel = new TreatmentModel();
$recordModel = new RecordModel();
$attachmentModel = new AttachmentModel();
$userModel = new UserModel();
$tokenModel = new TokenModel();

// ROUTES
require_once './routes/medicinesRoute.php';
require_once './routes/complaintsRoute.php';
require_once './routes/laboratoriesRoute.php';
require_once './routes/storagesRoute.php';
require_once './routes/treatmentsRoute.php';
require_once './routes/recordsRoute.php';
require_once './routes/attachmentsRoute.php';
require_once './routes/usersRoute.php';
require_once './routes/tokensRoute.php';

// Handle 404 Not Found
$router->set404(function () {
    http_response_code(404);
    $response = [
        "message" => "Not Found"
    ];
    echo json_encode($response);
});

// Run the router
$router->run();
