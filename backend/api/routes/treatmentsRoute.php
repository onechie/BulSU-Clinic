<?php 
$treatmentsController = new TreatmentsController($treatmentModel);

$router->get('/treatments', function () use ($treatmentsController) {
    if (isset($_GET['id'])) {
        return $treatmentsController->getTreatment($_GET);
    } else {
        return $treatmentsController->getTreatments();
    }
}, true);
$router->post('/treatments', function () use ($treatmentsController) {
    return $treatmentsController->addTreatment($_POST);
}, true);
$router->post('/treatments/update', function () use ($treatmentsController) {
    return $treatmentsController->updateTreatment($_POST);
}, true);
$router->post('/treatments/delete', function () use ($treatmentsController) {
    return $treatmentsController->deleteTreatment($_POST);
}, true);