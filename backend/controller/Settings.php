<?php
class SettingsController extends Utility
{
    private $complaintModel;
    private $laboratoryModel;
    private $treatmentModel;
    public function __construct(ComplaintModel $complaintModel, LaboratoryModel $laboratoryModel, TreatmentModel $treatmentModel)
    {
        $this->complaintModel = $complaintModel;
        $this->laboratoryModel = $laboratoryModel;
        $this->treatmentModel = $treatmentModel;
    }
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
}
