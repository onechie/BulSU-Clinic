<?php 
$treatmentModel = new TreatmentModel();
$treatmentsController = new TreatmentsController($treatmentModel);

$router->get('/treatments', function () use ($treatmentsController) {
    if (isset($_GET['id'])) {
        return $treatmentsController->getTreatment($_GET);
    } else {
        return $treatmentsController->getTreatments();
    }
});
$router->post('/treatments', function () use ($treatmentsController) {
    return $treatmentsController->addTreatment($_POST);
});
$router->post('/treatments/update', function () use ($treatmentsController) {
    return $treatmentsController->updateTreatment($_POST);
});
$router->post('/treatments/delete', function () use ($treatmentsController) {
    return $treatmentsController->deleteTreatment($_POST);
}); 