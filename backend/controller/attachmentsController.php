<?php
// Check if the file is being directly accessed via URL
require_once("../utils/utility.php");
Utility::preventDirectAccess();

class AttachmentsController extends Utility
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
            return $attachments ? $this->successResponseWithData("Attachments successfully fetched.", ['attachments' => $attachments]) : $this->errorResponse("No attachments found.");
        } catch (Exception $error) {
            return $this->errorResponse($error->getMessage());
        }
    }
    public function getAttachment($req)
    {
        $expectedKeys = ['id', 'recordId'];
        $req = $this->filterData($req, $expectedKeys);
        try {
            $attachment =  $this->getAttachmentIfExists($req);
            return $this->successResponseWithData("Attachment successfully fetched.", ['attachment' => $attachment]);
        } catch (Exception $error) {
            return $this->errorResponse($error->getMessage());
        }
    }
    public function addAttachment($req, $files)
    {
        $expectedKeys = ['recordId'];
        $req = $this->filterData($req, $expectedKeys);
        $formattedFiles = [];
        try {
            if ($this->hasFiles($files)) {
                $formattedFiles = $this->formatFiles($files['attachments']);
                $this->validateFiles($formattedFiles);
            } else {
                return $this->errorResponse("No files to upload.");
            }
            $this->onlyNum("Record ID", $req['recordId'] ?? null);
            $this->getRecordIfExists($req['recordId']);
            //TRY TO ADD ATTACHMENT
            $uploadedFilesData  = $this->uploadFiles($formattedFiles, $req['recordId']);
            $this->addAttachmentsOfRecord($uploadedFilesData, $req['recordId']);
            return $this->successResponse("Files successfully added.");
        } catch (Exception $error) {
            return $this->errorResponse($error->getMessage());
        }
    }
    public function deleteAttachment($req)
    {
        $expectedKeys = ['id', 'recordId'];
        $req = $this->filterData($req, $expectedKeys);
        try {
            $result = false;
            $attachments =  $this->getAttachmentIfExists($req);
            // CHECK $ATTACHMENTS IF IT IS ONLY ONE BECAUSE IF IT'S MANY IT MEANS NO ID IS PROVIDED ONLY INDEXES
            if (isset($attachments['id'])) {
                $this->deleteFile($attachments['url']);
                $result = $this->attachmentModel->deleteAttachment($attachments['id']);
            } else {
                $this->deleteFiles($attachments, $attachments[0]['recordId']);
                $result = $this->attachmentModel->deleteAttachmentByRecordId($attachments[0]['recordId']);
            }
            return $result ? $this->successResponse("Attachment successfully deleted.") : $this->errorResponse("Failed to delete attachment.");
        } catch (Exception $error) {
            return $this->errorResponse($error->getMessage());
        }
    }
    private function getAttachmentIfExists($req)
    {
        $id = $req['id'] ?? null;
        $recordId = $req['recordId'] ?? null;

        $attachment = [];
        if ($id) {
            $this->onlyNum("ID", $id);
            $attachment = $this->attachmentModel->getAttachment($id);
        } else {
            $this->onlyNum("Record ID", $recordId);
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
