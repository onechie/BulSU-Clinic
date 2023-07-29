<?php
// Check if the file is being directly accessed via URL
require_once("../utils/utility.php");
Utility::preventDirectAccess();

class RecordsController extends Utility
{
    private $recordModel;
    private $medicineModel;
    private $complaintModel;
    private $laboratoryModel;
    private $treatmentModel;
    private $attachmentModel;
    public function __construct(RecordModel $recordModel, MedicineModel $medicineModel, ComplaintModel $complaintModel, LaboratoryModel $laboratoryModel, TreatmentModel $treatmentModel, AttachmentModel $attachmentModel)
    {
        $this->recordModel = $recordModel;
        $this->medicineModel = $medicineModel;
        $this->complaintModel = $complaintModel;
        $this->laboratoryModel = $laboratoryModel;
        $this->treatmentModel = $treatmentModel;
        $this->attachmentModel = $attachmentModel;
    }
    public function getRecords()
    {
        try {
            //TRY TO GET ALL RECORDS
            $records = $this->recordModel->getRecords();
            return $records ? $this->successResponseWithData("Records successfully fetched.", ['records' => $records]) : $this->errorResponse("No records found.");
        } catch (Exception $error) {
            return $this->errorResponse($error->getMessage());
        }
    }
    public function getRecord($req)
    {
        $expectedKeys = ['id'];
        $req = $this->filterData($req, $expectedKeys);
        try {
            $this->onlyNum("ID", $req['id'] ?? null);
            //TRY TO GET RECORD BY ID
            $record = $this->getRecordIfExists($req['id']);
            $attachments = $this->attachmentModel->getAttachmentByRecordId($req['id']);
            $record['attachments'] = $attachments ?? [];
            return $this->successResponseWithData("Record successfully fetched.", ['record' => $record]);
        } catch (Exception $error) {
            return $this->errorResponse($error->getMessage());
        }
    }

    public function addRecord($req, $files)
    {
        $expectedKeys = ['schoolYear', 'name', 'date', 'complaint', 'medication', 'quantity', 'treatment', 'laboratory', 'bloodPressure', 'pulse', 'weight', 'temperature', 'respiration', 'oximetry'];
        $req = $this->filterData($req, $expectedKeys);
        $formattedFiles = [];
        try {
            $this->validateRecordData($req);
            if ($this->hasFiles($files)) {
                $formattedFiles = $this->formatFiles($files['attachments']);
                $this->validateFiles($formattedFiles);
            }
            $req = $this->fillMissingDataKeys($req, $expectedKeys);
            //TRY TO ADD RECORD
            $record = $this->recordModel->addRecord(...array_values($req));
            if ($record && $this->hasFiles($files)) {
                $uploadedFilesData  = $this->uploadFiles($formattedFiles, $record);
                $this->addAttachmentsOfRecord($uploadedFilesData, $record);
                return $this->successResponse("Record and files successfully added.");
            }
            return $record ? $this->successResponse("Record successfully added.") : $this->errorResponse("Record failed to add.");
        } catch (Exception $error) {
            return $this->errorResponse($error->getMessage());
        }
    }
    public function updateRecord($req)
    {
        $expectedKeys = ['id', 'schoolYear', 'name', 'date', 'complaint', 'medication', 'quantity', 'treatment', 'laboratory', 'bloodPressure', 'pulse', 'weight', 'temperature', 'respiration', 'oximetry'];
        $req = $this->filterData($req, $expectedKeys);
        try {
            $this->onlyNum("ID", $req['id'] ?? null);
            $oldRecord = $this->getRecordIfExists($req['id']);

            $newData = $this->mergeData($oldRecord, $req);
            $this->validateRecordData($newData);

            //TRY TO UPDATE RECORD
            $record = $this->recordModel->updateRecord(...array_values($newData));
            return $record ? $this->successResponse("Record successfully updated.") : $this->errorResponse("Record failed to update.");
        } catch (Exception $error) {
            return $this->errorResponse($error->getMessage());
        }
    }
    public function deleteRecord($req)
    {
        $expectedKeys = ['id'];
        $req = $this->filterData($req, $expectedKeys);
        try {
            $this->onlyNum("ID", $req['id'] ?? null);
            $this->getRecordIfExists($req['id']);
            
            //DELETE ATTACHMENTS
            $attachments = $this->attachmentModel->getAttachmentByRecordId($req['id']);
            $this->deleteFiles($attachments, $req['id'], true);
            //TRY TO DELETE RECORD
            $record = $this->recordModel->deleteRecord($req['id']);
            return $record ? $this->successResponse("Record successfully deleted.") : $this->errorResponse("Record failed to delete.");
        } catch (Exception $error) {
            return $this->errorResponse($error->getMessage());
        }
    }
    private function validateRecordData($recordData)
    {
        $schoolYear = $recordData['schoolYear'] ?? null;
        $name = $recordData['name'] ?? null;
        $date = $recordData['date'] ?? null;
        $complaint = $recordData['complaint'] ?? null;
        $medication = $recordData['medication'] ?? null;
        $quantity = $recordData['quantity'] ?? null;
        $treatment = $recordData['treatment'] ?? null;
        $laboratory = $recordData['laboratory'] ?? null;
        $bloodPressure = $recordData['bloodPressure'] ?? null;
        $pulse = $recordData['pulse'] ?? null;
        $weight = $recordData['weight'] ?? null;
        $temperature = $recordData['temperature'] ?? null;
        $respiration = $recordData['respiration'] ?? null;
        $oximetry = $recordData['oximetry'] ?? null;

        //REQUIRED FIELDS
        $this->onlyNum("School Year", strval($schoolYear));
        $this->onlyAlphaNum("Name", $name);
        $this->onlyDate("Date", $date);

        $this->onlyAlphaNum("Complaint", $complaint);
        $hasComplaint = $this->complaintModel->getComplaintByDescription($complaint);
        if (!$hasComplaint) {
            throw new Exception("Complaint does not exist.");
        }

        $this->onlyAlphaNum("Medication", $medication);
        $hasMedicine = $this->medicineModel->getMedicineByName($medication);
        if (!$hasMedicine) {
            throw new Exception("Medication does not exist.");
        }

        $this->onlyNum("Quantity", strval($quantity));
        if ($quantity < 1) {
            throw new Exception("Quantity must be greater than or equal to 1.");
        }
        if ($quantity > $hasMedicine['itemsCount']) {
            throw new Exception("Quantity must be less than or equal to the quantity of the stocks of medicine.");
        }

        //OPTIONAL FIELDS


        if ($treatment != null && $treatment != "") {
            $this->onlyAlphaNum("Treatment", $treatment);
            $hasTreatment = $this->treatmentModel->getTreatmentByDescription($treatment);
            if (!$hasTreatment) {
                throw new Exception("Treatment does not exist.");
            }
        }

        if ($laboratory != null && $laboratory != "") {
            $this->onlyAlphaNum("Laboratory", $laboratory);
            $hasLaboratory = $this->laboratoryModel->getLaboratoryByDescription($laboratory);
            if (!$hasLaboratory) {
                throw new Exception("Laboratory does not exist.");
            }
        }
        if ($bloodPressure != null && $bloodPressure != "") {
            $this->onlyAlphaNum("Blood Pressure", $bloodPressure);
        }
        if ($pulse != null && $pulse != "") {
            $this->onlyAlphaNum("Pulse", $pulse);
        }
        if ($weight != null && $weight != "") {
            $this->onlyAlphaNum("Weight", $weight);
        }
        if ($temperature != null && $temperature != "") {
            $this->onlyAlphaNum("Temperature", $temperature);
        }
        if ($respiration != null && $respiration != "") {
            $this->onlyAlphaNum("Respiration", $respiration);
        }
        if ($oximetry != null && $oximetry != "") {
            $this->onlyAlphaNum("Oximetry", $oximetry);
        }
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
    private function getRecordIfExists($id)
    {
        $record = $this->recordModel->getRecord($id);
        if (!$record) throw new Exception("Record does not exist.");
        return $record;
    }
}
