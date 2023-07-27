<?php
// Check if the file is being directly accessed via URL
require_once("../utils/utility.php");
Utility::preventDirectAccess();

class ComplaintsController extends Utility
{
    private $complaintModel;
    public function __construct(ComplaintModel $complaintModel)
    {
        $this->complaintModel = $complaintModel;
    }
    public function getComplaints()
    {
        try {
            //TRY TO GET ALL COMPLAINTS
            $complaints = $this->complaintModel->getComplaints();
            return $complaints ? $this->successResponseWithData("Complaints successfully fetched.", ['complaints' => $complaints]) : $this->errorResponse("No complaints found.");
        } catch (Exception $error) {
            return $this->errorResponse($error->getMessage());
        }
    }
    public function getComplaint($req)
    {
        $expectedKeys = ['id'];
        $req = $this->filterData($req, $expectedKeys);
        try {
            $this->onlyNum("ID", $req['id'] ?? null);

            //TRY TO GET COMPLAINT BY ID
            $complaint = $this->getComplaintIfExists($req['id']);
            return $this->successResponseWithData("Complaint successfully fetched.", ['complaint' => $complaint]);
        } catch (Exception $error) {
            return $this->errorResponse($error->getMessage());
        }
    }
    public function addComplaint($req)
    {
        $expectedKeys = ['description'];
        $req = $this->filterData($req, $expectedKeys);
        try {
            $this->onlyAlphaNum("Description", $req['description'] ?? null);
            $this->isComplaintDescriptionExists($req['description']);

            //TRY TO ADD COMPLAINT
            $result = $this->complaintModel->addComplaint(...array_values($req));
            return $result ? $this->successResponse("Complaint successfully added.") : $this->errorResponse("Complaint failed to add.");
        } catch (Exception $error) {
            return $this->errorResponse($error->getMessage());
        }
    }
    public function updateComplaint($req)
    {
        $expectedKeys = ['id', 'description'];
        $req = $this->filterData($req, $expectedKeys);
        try {
            $this->onlyNum("ID", $req['id'] ?? null);
            $oldComplaint = $this->getComplaintIfExists($req['id']);

            $newData = $this->mergeData($oldComplaint, $req); 
            $this->onlyAlphaNum("Description", $newData['description']);
            //TRY TO UPDATE COMPLAINT
            $result = $this->complaintModel->updateComplaint(...array_values($newData));
            return $result ? $this->successResponse("Complaint successfully updated.") : $this->errorResponse("Complaint failed to update.");
        } catch (Exception $error) {
            return $this->errorResponse($error->getMessage());
        }
    }
    public function deleteComplaint($req)
    {
        $expectedKeys = ['id'];
        $req = $this->filterData($req, $expectedKeys);
        try {
            $this->onlyNum("ID", $req['id'] ?? null);
            $this->getComplaintIfExists($req['id']);

            //TRY TO DELETE COMPLAINT
            $result = $this->complaintModel->deleteComplaint($req['id']);
            return $result ? $this->successResponse("Complaint successfully deleted.") : $this->errorResponse("Complaint failed to delete.");
        } catch (Exception $error) {
            return $this->errorResponse($error->getMessage());
        }
    }

    private function isComplaintDescriptionExists($description)
    {
        $complaint = $this->complaintModel->getComplaintByDescription($description);
        if ($complaint) throw new Exception("Complaint already exists.");
    }
    private function getComplaintIfExists($id)
    {
        $complaint = $this->complaintModel->getComplaint($id);
        if (!$complaint) throw new Exception("Complaint does not exist.");
        return $complaint;
    }
}