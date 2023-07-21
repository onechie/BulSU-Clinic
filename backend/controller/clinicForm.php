<?php
class ClinicFormController
{
    private $recordModel;
    private $attachmentModel;

    public function __construct(RecordModel $recordModel, AttachmentModel $attachmentModel)
    {
        $this->recordModel = $recordModel;
        $this->attachmentModel = $attachmentModel;
    }

    public function createRecord(array $inputData, array $fileData): array
    {
        $response = $this->validateInputData($inputData);
        if (!$response['success']) {
            return $response;
        }

        if (isset($fileData['name'])) {
            $fileValidationResult = $this->validateFiles($fileData);
            if (!$fileValidationResult['success']) {
                return $fileValidationResult;
            }
        }

        $result = $this->recordModel->createRecord(
            $inputData['schoolYear'],
            $inputData['name'],
            $inputData['date'],
            $inputData['complaint'],
            $inputData['medication'],
            $inputData['quantity'],
            $inputData['treatment'],
            $inputData['laboratory'],
            $inputData['bloodPressure'],
            $inputData['pulse'],
            $inputData['weight'],
            $inputData['temperature'],
            $inputData['respiration'],
            $inputData['oximetry']
        );

        if (!$result) {
            return $this->errorResponse("Internal Error: Unable to create record.");
        }

        $response = $this->successResponse("Record successfully created.");

        if (!isset($fileData['name'])) {
            return $response;
        }

        $attachmentsData = $this->processAttachments($fileData, $result);
        if ($attachmentsData['success'] === false) {
            return $this->errorResponse($attachmentsData['message']);
        }

        $this->saveAttachmentsToDatabase($attachmentsData['data'], $result);

        // Return success response with additional data
        return $this->successResponse("Record successfully created with attachments.");
    }

    private function validateInputData(array $inputData): array
    {
        $requiredFields = [
            'schoolYear' => 'School Year',
            'name' => 'Patient Name',
            'date' => 'Date',
            'complaint' => 'Complaint',
            'medication' => 'Medication',
            'quantity' => 'Quantity'
        ];

        foreach ($requiredFields as $field => $fieldName) {
            if (empty($inputData[$field])) {
                return $this->errorResponse($fieldName . " is a required field.");
            }
        }

        if (!is_string($inputData['name']) || strlen($inputData['name']) > 100) {
            return $this->errorResponse("Invalid name. Name must be a string with a maximum length of 100 characters.");
        }

        if (!DateTime::createFromFormat('Y-m-d', $inputData['date'])) {
            return $this->errorResponse("Invalid date format. Please use the YYYY-MM-DD format.");
        }

        // Add more validations for other fields here as needed...

        return $this->successResponse("Input data is valid.");
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
