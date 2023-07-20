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

    public function createRecord($inputData, $fileData)
    {
        $response = $this->validateInputData($inputData);
        if (!$response['success']) {
            return $response;
        }

        $result = $this->recordModel->setRecord(
            $inputData['sYear'],
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
            $response['success'] = false;
            $response['message'] = "Internal Error: Unable to create record.";
            return $response;
        }

        $response['success'] = true;
        $response['message'] = "Record successfully created.";

        if (!isset($fileData['name'])) {
            return $response; // No attachments to process
        }

        $attachmentsData = $this->processAttachments($fileData, $result);
        if ($attachmentsData === false) {
            $response['success'] = false;
            $response['message'] = "Error uploading attachments.";
            return $response;
        }

        $this->saveAttachmentsToDatabase($attachmentsData, $result);

        return $response;
    }

    private function validateInputData($inputData)
    {
        $response = [
            'success' => true,
            'message' => ''
        ];

        $requiredFields = ['sYear', 'name', 'date', 'complaint'];
        foreach ($requiredFields as $field) {
            if (empty($inputData[$field])) {
                $response['success'] = false;
                $response['message'] = ucfirst($field) . " is a required field.";
                return $response;
            }
        }

        return $response;
    }

    private function processAttachments($fileData, $recordId)
    {
        $attachmentsData = [];

        foreach ($fileData['tmp_name'] as $key => $tmpName) {
            if (isset($fileData['name'])) {
                $fileName = $fileData['name'][$key];

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
                    return false; // Error uploading file
                }
            }
        }

        return $attachmentsData;
    }

    private function saveAttachmentsToDatabase($attachmentsData, $recordId)
    {
        foreach ($attachmentsData as $attachment) {
            $attachmentName = $attachment['name'];
            $attachmentUrl = $attachment['url'];
            $this->attachmentModel->setAttachment($recordId, $attachmentName, $attachmentUrl);
        }
    }
}
