<?php 
$laboratoryModel = new LaboratoryModel();
$laboratoriesController = new LaboratoriesController($laboratoryModel);

$router->get('/laboratories', function () use ($laboratoriesController) {
    if (isset($_GET['id'])) {
        return $laboratoriesController->getLaboratory($_GET);
    } else {
        return $laboratoriesController->getLaboratories();
    }
});
$router->post('/laboratories', function () use ($laboratoriesController) {
    return $laboratoriesController->addLaboratory($_POST);
});
$router->post('/laboratories/update', function () use ($laboratoriesController) {
    return $laboratoriesController->updateLaboratory($_POST);
});
$router->post('/laboratories/delete', function () use ($laboratoriesController) {
    return $laboratoriesController->deleteLaboratory($_POST);
}); 