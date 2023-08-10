<?php
$medicinesController = new MedicinesController($medicineModel, $storageModel);

$router->get('/medicines', function () use ($medicinesController) {
    if (isset($_GET['id'])) {
        return $medicinesController->getMedicine($_GET);
    } else {
        return $medicinesController->getMedicines();
    }
}, true);
$router->post('/medicines', function () use ($medicinesController) {
    return $medicinesController->addMedicine($_POST);
}, true);
$router->post('/medicines/update', function () use ($medicinesController) {
    return $medicinesController->updateMedicine($_POST);
}, true);
$router->post('/medicines/delete', function () use ($medicinesController) {
    return $medicinesController->deleteMedicine($_POST);
}, true);