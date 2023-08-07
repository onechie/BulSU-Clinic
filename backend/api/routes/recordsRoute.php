<?php
$recordsController = new RecordsController(new RecordModel, new MedicineModel, new ComplaintModel, new LaboratoryModel, new TreatmentModel, new AttachmentModel);
$router->get('/records', function () use ($recordsController) {
    if (isset($_GET['id'])) {
        return $recordsController->getRecord($_GET);
    } else {
        return $recordsController->getRecords();
    }
}, true);
$router->post('/records', function () use ($recordsController) {
    return $recordsController->addRecord($_POST, $_FILES);
}, true);
$router->post('/records/update', function () use ($recordsController) {
    return $recordsController->updateRecord($_POST);
}, true);
$router->post('/records/delete', function () use ($recordsController) {
    return $recordsController->deleteRecord($_POST);
}, true);
