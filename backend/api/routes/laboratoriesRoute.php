<?php 
$laboratoriesController = new LaboratoriesController(new LaboratoryModel);

$router->get('/laboratories', function () use ($laboratoriesController) {
    if (isset($_GET['id'])) {
        return $laboratoriesController->getLaboratory($_GET);
    } else {
        return $laboratoriesController->getLaboratories();
    }
}, true);
$router->post('/laboratories', function () use ($laboratoriesController) {
    return $laboratoriesController->addLaboratory($_POST);
}, true);
$router->post('/laboratories/update', function () use ($laboratoriesController) {
    return $laboratoriesController->updateLaboratory($_POST);
}, true);
$router->post('/laboratories/delete', function () use ($laboratoriesController) {
    return $laboratoriesController->deleteLaboratory($_POST);
}, true); 