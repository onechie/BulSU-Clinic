<?php
class AttachmentsController 
{
    private $attachmentModel;
    private $recordModel;
    public function __construct(AttachmentModel $attachmentModel, RecordModel $recordModel)
    {
        $this->attachmentModel = $attachmentModel;
        $this->recordModel = $recordModel;
    }
    public function getAttachments()
    {
        try {
            //TRY TO GET ALL ATTACHMENTS
            $attachments = $this->attachmentModel->getAttachments();
            return $attachments ? Response::successResponseWithData("Attachments successfully fetched.", ['attachments' => $attachments]) :Response::errorResponse("No attachments found.");
        } catch (Throwable $error) {
            return Response::errorResponse($error->getMessage());
        }
    }
    public function getAttachment($req)
    {
        $expectedKeys = ['id', 'recordId'];
        $req = Data::filterData($req, $expectedKeys);
        try {
            $attachment =  $this->getAttachmentIfExists($req);
            return Response::successResponseWithData("Attachment successfully fetched.", ['attachment' => $attachment]);
        } catch (Throwable $error) {
            return Response::errorResponse($error->getMessage());
        }
    }
    public function addAttachment($req, $files)
    {
        $expectedKeys = ['recordId'];
        $req = Data::filterData($req, $expectedKeys);
        $formattedFiles = [];
        try {
            if (File::hasFiles($files)) {
                $formattedFiles = File::formatFiles($files['attachments']);
                File::validateFiles($formattedFiles);
            } else {
                return Response::errorResponse("No files to upload.");
            }
            Data::onlyNum("Record ID", $req['recordId'] ?? null);
            $this->getRecordIfExists($req['recordId']);
            //TRY TO ADD ATTACHMENT
            $uploadedFilesData  = File::uploadFiles($formattedFiles, $req['recordId']);
            $this->addAttachmentsOfRecord($uploadedFilesData, $req['recordId']);
            return Response::successResponse("Files successfully added.");
        } catch (Throwable $error) {
            return Response::errorResponse($error->getMessage());
        }
    }
    public function deleteAttachment($req)
    {
        $expectedKeys = ['id', 'recordId'];
        $req = Data::filterData($req, $expectedKeys);
        try {
            $result = false;
            $attachments =  $this->getAttachmentIfExists($req);
            // CHECK $ATTACHMENTS IF IT IS ONLY ONE BECAUSE IF IT'S MANY IT MEANS NO ID IS PROVIDED ONLY INDEXES
            if (isset($attachments['id'])) {
                File::deleteFile($attachments['url']);
                $result = $this->attachmentModel->deleteAttachment($attachments['id']);
            } else {
                File::deleteFiles($attachments, $attachments[0]['recordId']);
                $result = $this->attachmentModel->deleteAttachmentByRecordId($attachments[0]['recordId']);
            }
            return $result ? Response::successResponse("Attachment successfully deleted.") : Response::errorResponse("Failed to delete attachment.");
        } catch (Throwable $error) {
            return Response::errorResponse($error->getMessage());
        }
    }
    private function getAttachmentIfExists($req)
    {
        $id = $req['id'] ?? null;
        $recordId = $req['recordId'] ?? null;

        $attachment = [];
        if ($id) {
            Data::onlyNum("ID", $id);
            $attachment = $this->attachmentModel->getAttachment($id);
        } else {
            Data::onlyNum("Record ID", $recordId);
            $attachment = $this->attachmentModel->getAttachmentByRecordId($recordId);
        }
        if (!$attachment) {
            throw new Exception("Attachment not found.");
        }
        return $attachment;
    }
    private function getRecordIfExists($id)
    {
        $record = $this->recordModel->getRecord($id);
        if (!$record) {
            throw new Exception("Record ID not exists.");
        }
        return $record;
    }
    private function addAttachmentsOfRecord($files, $recordId)
    {
        foreach ($files as $file) {
            $result = $this->attachmentModel->addAttachment($recordId, $file['name'], $file['url']);
            if (!$result) {
                throw new Exception("Failed to add attachment.");
            }
        }
    }
}
