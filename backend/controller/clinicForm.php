<?php
// Check if the file is being directly accessed via URL
require_once("../utils/utility.php");
Utility::preventDirectAccess();
// class ClinicFormController extends Utility
// {
//     private const ALLOWED_EXTENSIONS = ['pdf', 'txt', 'jpg', 'jpeg', 'png', 'gif', 'docx'];

//     private $recordModel;
//     private $attachmentModel;
//     private $complaintModel;
//     private $medicineModel;
//     private $treatmentModel;
//     private $laboratoryModel;

//     public function __construct(
//         RecordModel $recordModel,
//         AttachmentModel $attachmentModel,
//         ComplaintModel $complaintModel,
//         MedicineModel $medicineModel,
//         TreatmentModel $treatmentModel,
//         LaboratoryModel $laboratoryModel
//     ) {
//         $this->recordModel = $recordModel;
//         $this->attachmentModel = $attachmentModel;
//         $this->complaintModel = $complaintModel;
//         $this->medicineModel = $medicineModel;
//         $this->treatmentModel = $treatmentModel;
//         $this->laboratoryModel = $laboratoryModel;
//     }

//     public function getFormSuggestions(): array
//     {
//         $suggestions = [
//             'complaints' => $this->complaintModel->getAllComplaints(),
//             'medications' => $this->medicineModel->getAllMedicines(),
//             'treatments' => $this->treatmentModel->getAllTreatments(),
//             'laboratories' => $this->laboratoryModel->getAllLaboratories()
//         ];

//         return $this->successResponseWithData("Form suggestions successfully retrieved.", $suggestions);
//     }

//     public function createRecord(array $inputData, array $fileData): array
//     {
//         $validationResult = $this->validateInputData($inputData);
//         if (!$validationResult['success']) {
//             return $validationResult;
//         }

//         if (!empty($fileData['name'])) {
//             $fileValidationResult = $this->validateFiles($fileData);
//             if (!$fileValidationResult['success']) {
//                 return $fileValidationResult;
//             }
//         }

//         $recordId = $this->recordModel->createRecord(
//             $inputData['schoolYear'],
//             $inputData['name'],
//             $inputData['date'],
//             $inputData['complaint'],
//             $inputData['medication'],
//             $inputData['quantity'],
//             $inputData['treatment'],
//             $inputData['laboratory'],
//             $inputData['bloodPressure'],
//             $inputData['pulse'],
//             $inputData['weight'],
//             $inputData['temperature'],
//             $inputData['respiration'],
//             $inputData['oximetry']
//         );

//         if (!$recordId) {
//             return $this->errorResponse("Internal Error: Unable to create record.");
//         }

//         if (!empty($fileData['name'])) {
//             $attachmentsData = $this->processAttachments($fileData, $recordId);
//             if (!$attachmentsData['success']) {
//                 return $this->errorResponse($attachmentsData['message']);
//             }
//             $this->saveAttachmentsToDatabase($attachmentsData['data'], $recordId);
//         }

//         $message = !empty($fileData['name']) ? "Record successfully created with attachments." : "Record successfully created.";
//         return $this->successResponse($message);
//     }

//     private function validateInputData(array $inputData): array
//     {
//         $requiredFields = [
//             'schoolYear' => 'School Year',
//             'name' => 'Patient Name',
//             'date' => 'Date',
//             'complaint' => 'Complaint',
//             'medication' => 'Medication',
//             'quantity' => 'Quantity'
//         ];

//         foreach ($requiredFields as $field => $fieldName) {
//             if (empty($inputData[$field])) {
//                 return $this->errorResponse($fieldName . " is a required field.");
//             }
//         }

//         if (!is_string($inputData['name']) || strlen($inputData['name']) > 100) {
//             return $this->errorResponse("Invalid name. Name must be a string with a maximum length of 100 characters.");
//         }

//         if (!DateTime::createFromFormat('Y-m-d', $inputData['date'])) {
//             return $this->errorResponse("Invalid date format. Please use the YYYY-MM-DD format.");
//         }
//         if ($inputData['quantity'] <= 0) {
//             return $this->errorResponse("Invalid quantity. Quantity must be greater than 0.");
//         }

//         $medicineMaxQuantity = $this->medicineModel->getMedicineByName($inputData['medication']);
//         if ($inputData['quantity'] > $medicineMaxQuantity['itemsC']) {
//             $message = $medicineMaxQuantity['itemsC'] == 0 ? "Invalid quantity. " . $medicineMaxQuantity['name'] . " is out of stock." : "Invalid quantity. Quantity must be less than or equal to " . $medicineMaxQuantity['itemsC'] . ".";
//             return $this->errorResponse($message);
//         }

//         $updatedQuantity = $medicineMaxQuantity['itemsC'] - $inputData['quantity'];
//         $updatedItemsDeducted = $medicineMaxQuantity['itemsD'] + $inputData['quantity'];
//         $medicineUpdated = $this->medicineModel->updateMedicineById($medicineMaxQuantity['id'], $updatedQuantity, $updatedItemsDeducted);
//         if (!$medicineUpdated) {
//             return $this->errorResponse("Internal Error: Unable to update medicine.");
//         }

//         // Add more validations for other fields here as needed...

//         return $this->successResponse("Input data is valid.");
//     }

//     private function validateFiles(array $fileData): array
//     {
//         foreach ($fileData['tmp_name'] as $key => $tmpName) {
//             if (isset($fileData['name'])) {
//                 $fileName = $fileData['name'][$key];
//                 $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

//                 if (!in_array($fileExtension, self::ALLOWED_EXTENSIONS)) {
//                     return $this->errorResponse("Invalid file type. Only PDF, TXT, JPG, JPEG, PNG, GIF, and DOCX files are allowed.");
//                 }
//             }
//         }

//         return $this->successResponse("Files are valid.");
//     }

//     private function processAttachments(array $fileData, $recordId): array
//     {
//         $attachmentsData = [];

//         foreach ($fileData['tmp_name'] as $key => $tmpName) {
//             if (isset($fileData['name'])) {
//                 $fileName = $fileData['name'][$key];
//                 $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

//                 $uploadDir = "../../src/attachments/" . $recordId . "/";

//                 if (!is_dir($uploadDir)) {
//                     mkdir($uploadDir, 0777, true);
//                 }

//                 $uniqueFileName = uniqid() . '_' . $fileName;
//                 $uploadedFilePath = $uploadDir . $uniqueFileName;

//                 if (move_uploaded_file($tmpName, $uploadedFilePath)) {
//                     $attachmentUrl = './src/attachments/' . $recordId . '/' . $uniqueFileName;
//                     $attachmentsData[] = [
//                         'name' => $uniqueFileName,
//                         'url' => $attachmentUrl
//                     ];
//                 } else {
//                     return $this->errorResponse("Error uploading file.");
//                 }
//             }
//         }

//         return [
//             'success' => true,
//             'data' => $attachmentsData
//         ];
//     }

//     private function saveAttachmentsToDatabase(array $attachmentsData, $recordId): void
//     {
//         foreach ($attachmentsData as $attachment) {
//             $attachmentName = $attachment['name'];
//             $attachmentUrl = $attachment['url'];
//             $this->attachmentModel->addAttachment($recordId, $attachmentName, $attachmentUrl);
//         }
//     }
// }
