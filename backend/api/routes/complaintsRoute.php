<?php 
$complaintsController = new ComplaintsController($complaintModel);

$router->get('/complaints', function () use ($complaintsController) {
    if (isset($_GET['id'])) {
        return $complaintsController->getComplaint($_GET);
    } else {
        return $complaintsController->getComplaints();
    }
});
$router->post('/complaints', function () use ($complaintsController) {
    return $complaintsController->addComplaint($_POST);
});
$router->post('/complaints/update', function () use ($complaintsController) {
    return $complaintsController->updateComplaint($_POST);
});
$router->post('/complaints/delete', function () use ($complaintsController) {
    return $complaintsController->deleteComplaint($_POST);
}); 