<?php

class RecordsController
{
    private $recordModel;
    private $medicineModel;
    private $attachmentModel;
    private $logModel;
    public function __construct(RecordModel $recordModel, MedicineModel $medicineModel, AttachmentModel $attachmentModel, LogModel $logModel)
    {
        $this->recordModel = $recordModel;
        $this->medicineModel = $medicineModel;
        $this->attachmentModel = $attachmentModel;
        $this->logModel = $logModel;
    }
    public function getRecords()
    {
        try {
            //TRY TO GET ALL RECORDS
            $records = $this->recordModel->getRecords();
            return $records ? Response::successResponseWithData("Records successfully fetched.", ['records' => $records]) : Response::errorResponse("No records found.");
        } catch (Throwable $error) {
            return Response::errorResponse($error->getMessage());
        }
    }
    public function getRecord($req)
    {
        $expectedKeys = ['id', 'patientName'];
        $req = Data::filterData($req, $expectedKeys);
        try {
            //TRY TO GET RECORD BY ID OR NAME
            $record = $this->getRecordByIdOrName($req);
            return Response::successResponseWithData("Record successfully fetched.", ['record' => $record]);
        } catch (Throwable $error) {
            return Response::errorResponse($error->getMessage());
        }
    }

    public function addRecord($req, $files)
    {
        $expectedKeys = ['schoolYear', 'name', 'date', 'type', 'complaint', 'medication', 'quantity', 'treatment', 'laboratory', 'bloodPressure', 'pulse', 'weight', 'temperature', 'respiration', 'oximetry'];
        $req = Data::filterData($req, $expectedKeys);
        $formattedFiles = [];
        try {
            $this->validateRecordData($req);
            if (File::hasFiles($files)) {
                $formattedFiles = File::formatFiles($files['attachments']);
                File::validateFiles($formattedFiles);
            }
            $req = Data::fillMissingDataKeys($req, $expectedKeys);

            $access_token = $_COOKIE['a_jwt'] ?? '';
            $accessJWTData = Auth::validateAccessJWT($access_token);
            if ($accessJWTData->type !== "ACCESS") {
                return Response::errorResponse("Access token is invalid.");
            }
            $req['userCreated'] = $accessJWTData->username;

            //TRY TO ADD RECORD
            $record = $this->recordModel->addRecord(...array_values($req));
            $this->updateMedicineQuantity($req['medication'], $req['quantity']);
            if ($record && File::hasFiles($files)) {
                $uploadedFilesData  = File::uploadFiles($formattedFiles, $record);
                $this->addAttachmentsOfRecord($uploadedFilesData, $record);
                return Response::successResponse("Record and files successfully added.");
            }
            $this->generateLog($record, "Add Clinic Record", "A new record created for " . $req['name'] . " with complaint \"" . $req['complaint'] . "\" and medication \"" . $req['medication'] . "\" with quantity of " . $req['quantity'] . ". Record ID = " . $record);
            return $record ? Response::successResponse("Record successfully added.") : Response::errorResponse("Record failed to add.");
        } catch (Throwable $error) {
            return Response::errorResponse($error->getMessage());
        }
    }
    public function updateRecord($req)
    {
        $expectedKeys = ['id', 'schoolYear', 'name', 'date', 'complaint', 'medication', 'quantity', 'treatment', 'laboratory', 'bloodPressure', 'pulse', 'weight', 'temperature', 'respiration', 'oximetry'];
        $req = Data::filterData($req, $expectedKeys);
        try {
            Data::onlyNum("ID", $req['id'] ?? null);
            $oldRecord = $this->getRecordIfExists($req['id']);

            $newData = Data::mergeData($oldRecord, $req);
            $this->validateRecordData($newData);

            //TRY TO UPDATE RECORD
            $record = $this->recordModel->updateRecord(...array_values($newData));
            $updatedValues = '';
            foreach ($newData as $key => $value) {
                if ($oldRecord[$key] != $value) {
                    $oldValue = $oldRecord[$key];
                    $newValue = $value;
                    $updatedValues .= " [" . $key . ": " . $oldValue . " to " . $newValue . "],";
                }
            }
            $this->generateLog($record, "Update Record", "Record Changes" . substr($updatedValues, 0, -1) . ". Record ID = " . $req['id']);
            return $record ? Response::successResponse("Record successfully updated.") : Response::errorResponse("Record failed to update.");
        } catch (Throwable $error) {
            return Response::errorResponse($error->getMessage());
        }
    }
    public function deleteRecord($req)
    {
        $expectedKeys = ['id'];
        $req = Data::filterData($req, $expectedKeys);
        try {
            Data::onlyNum("ID", $req['id'] ?? null);
            $record = $this->getRecordIfExists($req['id']);

            //DELETE ATTACHMENTS
            $attachments = $this->attachmentModel->getAttachmentByRecordId($req['id']);
            File::deleteFiles($attachments, $req['id'], true);
            //TRY TO DELETE RECORD
            $result = $this->recordModel->deleteRecord($req['id']);
            $this->generateLog($result, "Delete Record", "Record of " . $record["name"] . " deleted. Record ID = " . $req['id']);
            return $result ? Response::successResponse("Record successfully deleted.") : Response::errorResponse("Record failed to delete.");
        } catch (Throwable $error) {
            return Response::errorResponse($error->getMessage());
        }
    }
    private function validateRecordData($recordData)
    {
        $schoolYear = $recordData['schoolYear'] ?? null;
        $name = $recordData['name'] ?? null;
        $date = $recordData['date'] ?? null;
        $complaint = $recordData['complaint'] ?? null;
        $type = $recordData['type'] ?? null;
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
        Data::onlyNum("School Year", strval($schoolYear));
        Data::onlyAlphaNum("Name", $name);
        Data::onlyDate("Date", $date);
        Data::onlyAlphaNum("Patient type", $type);
        Data::onlyAlphaNum("Complaint", $complaint);
        Data::onlyAlphaNum("Medication", $medication);
        $hasMedicine = $this->medicineModel->getMedicineByName($medication);
        if (!$hasMedicine) {
            throw new Exception("Medication does not exist.");
        }
        Data::onlyNum("Quantity", strval($quantity));
        if ($hasMedicine['itemsCount'] - $hasMedicine['itemsDeducted'] <= 0) {
            throw new Exception("Medicine is out of stock.");
        }
        if ($quantity < 1) {
            throw new Exception("Quantity must be greater than or equal to 1.");
        }
        if ($quantity > $hasMedicine['itemsCount']) {
            throw new Exception("Quantity must be less than or equal to the quantity of the stocks of medicine.");
        }

        //OPTIONAL FIELDS
        if ($treatment != null && $treatment != "") {
            Data::onlyAlphaNum("Treatment", $treatment);
        }

        if ($laboratory != null && $laboratory != "") {
            Data::onlyAlphaNum("Laboratory", $laboratory);
        }
        if ($bloodPressure != null && $bloodPressure != "") {
            Data::onlyAlphaNum("Blood Pressure", $bloodPressure);
        }
        if ($pulse != null && $pulse != "") {
            Data::onlyAlphaNum("Pulse", $pulse);
        }
        if ($weight != null && $weight != "") {
            Data::onlyAlphaNum("Weight", $weight);
        }
        if ($temperature != null && $temperature != "") {
            Data::onlyAlphaNum("Temperature", $temperature);
        }
        if ($respiration != null && $respiration != "") {
            Data::onlyAlphaNum("Respiration", $respiration);
        }
        if ($oximetry != null && $oximetry != "") {
            Data::onlyAlphaNum("Oximetry", $oximetry);
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
    private function getRecordByIdOrName($req)
    {
        $id = $req['id'] ?? null;
        $patientName = $req['patientName'] ?? null;

        $record = [];
        if ($id) {
            Data::onlyNum("ID", $id);
            $record = $this->recordModel->getRecord($id);
            if (!$record) {
                throw new Exception("Record not found.");
            }
            $attachments = $this->attachmentModel->getAttachmentByRecordId($id);
            $record['attachments'] = $attachments ?? [];
        } else {
            Data::onlyAlphaNum("Patient's Name", $patientName);
            $record = $this->recordModel->getRecordsByPatientName($patientName);
            if (!$record) {
                throw new Exception("No records found.");
            }
        }
        if (!$record) {
            throw new Exception("Attachment not found.");
        }
        return $record;
    }
    private function updateMedicineQuantity($medicine, $quantity)
    {
        $medicineData = $this->medicineModel->getMedicineByName($medicine);
        $this->medicineModel->updateMedicine(
            $medicineData['id'],
            $medicineData['name'],
            $medicineData['brand'],
            $medicineData['unit'],
            $medicineData['expiration'],
            $medicineData['boxesCount'],
            $medicineData['itemsPerBox'],
            $medicineData['itemsCount'],
            $medicineData['itemsDeducted'] + $quantity,
            $medicineData['storage'],
        );
    }
    private function generateLog($condition, $action, $description)
    {
        if (!$condition) return;
        $access_token = $_COOKIE['a_jwt'] ?? '';
        $accessJWTData = Auth::validateAccessJWT($access_token);

        $userId = $accessJWTData->sub;
        $username = $accessJWTData->username;
        $this->logModel->addLog($userId, $username, $action, $description);
    }
}
