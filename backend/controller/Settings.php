<?php
// Check if the file is being directly accessed via URL
require_once("../utils/utility.php");
Utility::preventDirectAccess();
class SettingsController extends Utility
{
    private $complaintModel;
    private $laboratoryModel;
    private $treatmentModel;
    private $storageModel;
    public function __construct(ComplaintModel $complaintModel, LaboratoryModel $laboratoryModel, TreatmentModel $treatmentModel, StorageModel $storageModel)
    {
        $this->complaintModel = $complaintModel;
        $this->laboratoryModel = $laboratoryModel;
        $this->treatmentModel = $treatmentModel;
        $this->storageModel = $storageModel;
    }
    //COMPLAINTS
    public function getComplaints(): array
    {
        $complaints = $this->complaintModel->getAllComplaints();
        return $this->successResponseWithData("Complaints successfully fetched.", ['complaints' => $complaints]);
    }
    public function addComplaint(string $description): array
    {
        if ($description == "") {
            return $this->errorResponse("Complaint description cannot be empty.");
        }
        if ($this->complaintModel->getComplaint($description)) {
            return $this->errorResponse("Complaint already exists.");
        }
        $this->complaintModel->addComplaint($description);
        return $this->successResponse("Complaint successfully added.");
    }
    public function deleteComplaint(int $id): array
    {
        $this->complaintModel->deleteComplaint($id);
        return $this->successResponse("Complaint successfully deleted.");
    }
    //TREATMENTS
    public function getTreatments(): array
    {
        $treatments = $this->treatmentModel->getAllTreatments();
        return $this->successResponseWithData("Treatments successfully fetched.", ['treatments' => $treatments]);
    }
    public function addTreatment(string $description): array
    {
        if ($description == "") {
            return $this->errorResponse("Treatment description cannot be empty.");
        }
        if ($this->treatmentModel->getTreatment($description)) {
            return $this->errorResponse("Treatment already exists.");
        }
        $this->treatmentModel->addTreatment($description);
        return $this->successResponse("Treatment successfully added.");
    }
    public function deleteTreatment(int $id): array
    {
        $this->treatmentModel->deleteTreatment($id);
        return $this->successResponse("Treatment successfully deleted.");
    }
    //LABORATORIES
    public function getLaboratories(): array
    {
        $laboratories = $this->laboratoryModel->getAllLaboratories();
        return $this->successResponseWithData("Laboratories successfully fetched.", ['laboratories' => $laboratories]);
    }
    public function addLaboratory(string $description): array
    {
        if ($description == "") {
            return $this->errorResponse("Laboratory description cannot be empty.");
        }
        if ($this->laboratoryModel->getLaboratory($description)) {
            return $this->errorResponse("Laboratory already exists.");
        }
        $this->laboratoryModel->addLaboratory($description);
        return $this->successResponse("Laboratory successfully added.");
    }
    public function deleteLaboratory(int $id): array
    {
        $this->laboratoryModel->deleteLaboratory($id);
        return $this->successResponse("Laboratory successfully deleted.");
    }
    //STORAGES
    public function getStorages(): array
    {
        $storages = $this->storageModel->getAllStorages();
        return $this->successResponseWithData("Storages successfully fetched.", ['storages' => $storages]);
    }
    public function addStorage(string $description): array
    {
        if ($description == "") {
            return $this->errorResponse("Storage description cannot be empty.");
        }
        if ($this->storageModel->getStorage($description)) {
            return $this->errorResponse("Storage already exists.");
        }
        $this->storageModel->addStorage($description);
        return $this->successResponse("Storage successfully added.");
    }
    public function deleteStorage($id): array
    {
        $this->storageModel->deleteStorage($id);
        return $this->successResponse("Storage successfully deleted.");
    }
}
