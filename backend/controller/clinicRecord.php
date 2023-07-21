<?php
class ClinicRecordController
{
    private $recordModel;
    private $attachmentModel;
    public function __construct(RecordModel $recordModel, AttachmentModel $attachmentModel)
    {
        $this->recordModel = $recordModel;
        $this->attachmentModel = $attachmentModel;
    }

    public function getAllRecords(): array
    {
        $records = $this->recordModel->getAllRecords();

        if (empty($records)) {
            return $this->errorResponse("No records found.");
        }

        return $this->successResponseWithData("Records successfully retrieved.", ['records' => $records]);
    }

    public function getRecordsByName(string $name): array
    {
        if (empty($name)) {
            return $this->errorResponse("Name parameter is required.");
        }

        $records = $this->recordModel->getRecordsByName($name);

        if (empty($records)) {
            return $this->errorResponse("No records found with the provided name.");
        }

        return $this->successResponseWithData("Records successfully retrieved by name.", ['records' => $records]);
    }

    public function getRecordById(int $id): array
    {
        $data = [];

        if ($id <= 0) {
            return $this->errorResponse("Invalid ID parameter.");
        }

        $record = $this->recordModel->getRecordById($id);

        if (!$record) {
            return $this->errorResponse("Record not found.");
        }

        $data = ['record' => $record];
        $attachments = $this->attachmentModel->getAttachmentsByRecordId($id);

        if ($attachments) {
            $data = ['record' => $record, 'attachments' => $attachments];
        }

        return $this->successResponseWithData("Record successfully retrieved.", $data);
    }

    public function addAttachment($recordData, $fileData)
    {
        $id = $recordData['id'];

        $fileValidationResult = $this->validateFiles($fileData);
        if (!$fileValidationResult['success']) {
            return $fileValidationResult;
        }
        $attachmentsData = $this->processAttachments($fileData, $id);
        if ($attachmentsData['success'] === false) {
            return $this->errorResponse($attachmentsData['message']);
        }

        $this->saveAttachmentsToDatabase($attachmentsData['data'], $id);

        return $this->successResponse("Attachment added successfully");
    }
    private function validateFiles(array $fileData): array
    {
        $allowedExtensions = ['pdf', 'txt', 'jpg', 'jpeg', 'png', 'gif', 'docx'];

        foreach ($fileData['tmp_name'] as $key => $tmpName) {
            if (isset($fileData['name'])) {
                $fileName = $fileData['name'][$key];
                $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                if (!in_array($fileExtension, $allowedExtensions)) {
                    return $this->errorResponse("Invalid file type. Only PDF, TXT, JPG, JPEG, PNG, GIF, and DOCX files are allowed.");
                }
            }
        }

        return $this->successResponse("Files are valid.");
    }
    private function processAttachments(array $fileData, $recordId): array
    {
        $attachmentsData = [];

        foreach ($fileData['tmp_name'] as $key => $tmpName) {
            if (isset($fileData['name'])) {
                $fileName = $fileData['name'][$key];
                $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                $uploadDir = "../../src/attachments/" . $recordId . "/";

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $uniqueFileName = uniqid() . '_' . $fileName;
                $uploadedFilePath = $uploadDir . $uniqueFileName;

                if (move_uploaded_file($tmpName, $uploadedFilePath)) {
                    $attachmentUrl = './src/attachments/' . $recordId . '/' . $uniqueFileName;
                    $attachmentsData[] = [
                        'name' => $uniqueFileName,
                        'url' => $attachmentUrl
                    ];
                } else {
                    return $this->errorResponse("Error uploading file.");
                }
            }
        }

        return [
            'success' => true,
            'data' => $attachmentsData
        ];
    }
    private function saveAttachmentsToDatabase(array $attachmentsData, $recordId): void
    {
        foreach ($attachmentsData as $attachment) {
            $attachmentName = $attachment['name'];
            $attachmentUrl = $attachment['url'];
            $this->attachmentModel->addAttachment($recordId, $attachmentName, $attachmentUrl);
        }
    }

    private function successResponse(string $message): array
    {
        return ['success' => true, 'message' => $message];
    }

    private function successResponseWithData(string $message, array $data): array
    {
        return ['success' => true, 'message' => $message] + $data;
    }

    private function errorResponse(string $message): array
    {
        return ['success' => false, 'message' => $message];
    }
}
