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
            if (!$complaints) {
                return $this->errorResponse("No complaints found.");
            }
            return $this->successResponseWithData("Complaints successfully fetched.", ['complaints' => $complaints]);
        } catch (Exception $error) {
            return $this->errorResponse($error->getMessage());
        }
    }
    public function getComplaint($req)
    {
        $expectedKeys = ['id'];
        try {
            //REMOVE UNEXPECTED KEY VALUE PAIRS
            $req = array_intersect_key($req, array_flip($expectedKeys));

            //INPUT VALIDATION
            $this->onlyNum("ID", $req['id'] ?? null);
            //TRY TO GET COMPLAINT BY ID
            $complaint = $this->complaintModel->getComplaint($req['id']);
            if (!$complaint) {
                return $this->errorResponse("Complaint does not exist.");
            }
            return $this->successResponseWithData("Complaint successfully fetched.", ['complaint' => $complaint]);
        } catch (Exception $error) {
            return $this->errorResponse($error->getMessage());
        }
    }
    public function addComplaint($req)
    {
        $expectedKeys = ['description'];
        try {
            //REMOVE UNEXPECTED KEY VALUE PAIRS
            $req = array_intersect_key($req, array_flip($expectedKeys));

            //INPUT VALIDATION
            $this->onlyAlphaNum("Description", $req['description'] ?? null);

            //CHECK IF COMPLAINT ALREADY EXISTS
            $this->complaintDescriptionExists($req['description']);

            //TRY TO ADD COMPLAINT
            $result = $this->complaintModel->addComplaint(...array_values($req));
            if (!$result) {
                return $this->errorResponse("Complaint failed to add.");
            }
            return $this->successResponse("Complaint successfully added.");
        } catch (Exception $error) {
            return $this->errorResponse($error->getMessage());
        }
    }
    public function updateComplaint($req)
    {
        $expectedKeys = ['id', 'description'];
        try {
            //REMOVE UNEXPECTED KEY VALUE PAIRS
            $req = array_intersect_key($req, array_flip($expectedKeys));

            //INPUT VALIDATION
            $this->onlyNum("ID", $req['id'] ?? null);

            //CHECK IF COMPLAINT EXISTS
            $oldComplaint = $this->complaintModel->getComplaint($req['id']);
            if (!$oldComplaint) {
                throw new Exception("Complaint does not exist.");
            }

            //REMOVE EMPTY ARRAY VALUES TO PREPARE FOR MERGE
            $req = array_filter($req, function ($value) {
                return !empty($value);
            });

            //MERGE OLD COMPLAINT DATA WITH NEW COMPLAINT DATA ONLY
            $newComplaintData = array_merge($oldComplaint, $req);

            //CHECK IF THERE ARE ANY CHANGES
            $differences = array_diff_assoc($oldComplaint, $newComplaintData);
            if (empty($differences)) {
                return $this->errorResponse("No changes were made.");
            }

            //INPUT VALIDATION
            $this->onlyAlphaNum("Description", $newComplaintData['description']);

            //TRY TO UPDATE COMPLAINT
            $result = $this->complaintModel->updateComplaint(...array_values($newComplaintData));
            if (!$result) {
                return $this->errorResponse("Complaint failed to update.");
            }
            return $this->successResponse("Complaint successfully updated.");
        } catch (Exception $error) {
            return $this->errorResponse($error->getMessage());
        }
    }
    public function deleteComplaint($req)
    {
        $expectedKeys = ['id'];
        try {
            //REMOVE UNEXPECTED KEY VALUE PAIRS
            $req = array_intersect_key($req, array_flip($expectedKeys));

            //INPUT VALIDATION
            $this->onlyNum("ID", $req['id'] ?? null);

            //CHECK IF COMPLAINT EXISTS
            $complaint = $this->complaintModel->getComplaint($req['id']);
            if (!$complaint) {
                return $this->errorResponse("Complaint does not exist.");
            }

            //TRY TO DELETE COMPLAINT
            $result = $this->complaintModel->deleteComplaint($req['id']);
            if (!$result) {
                return $this->errorResponse("Complaint failed to delete.");
            }
            return $this->successResponse("Complaint successfully deleted.");
        } catch (Exception $error) {
            return $this->errorResponse($error->getMessage());
        }
    }

    private function complaintDescriptionExists($description)
    {
        $complaint = $this->complaintModel->getComplaintByDescription($description);
        if ($complaint) throw new Exception("Complaint already exists.");
    }
}
