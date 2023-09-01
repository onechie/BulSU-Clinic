<?php
$attachmentsController = new AttachmentsController($attachmentModel, $recordModel, $logModel);

$router->get('/attachments', function () use ($attachmentsController) {
    if (isset($_GET['id']) || isset($_GET['recordId'])) {
        return $attachmentsController->getAttachment($_GET);
    } else {
        return $attachmentsController->getAttachments();
    }
}, true);
$router->post('/attachments', function () use ($attachmentsController) {
    return $attachmentsController->addAttachment($_POST, $_FILES);
}, true);
// $router->post('/attachments/update', function () use ($attachmentsController) {
//     return $attachmentsController->updateAttachment($_POST);
// });
$router->post('/attachments/delete', function () use ($attachmentsController) {
    return $attachmentsController->deleteAttachment($_POST);
}, true);
