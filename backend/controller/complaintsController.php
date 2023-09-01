<?php

class ComplaintsController
{
    private $complaintModel;
    private $logModel;
    public function __construct(ComplaintModel $complaintModel, LogModel $logModel)
    {
        $this->complaintModel = $complaintModel;
        $this->logModel = $logModel;
    }
    public function getComplaints()
    {
        try {
            //TRY TO GET ALL COMPLAINTS
            $complaints = $this->complaintModel->getComplaints();
            return $complaints ? Response::successResponseWithData("Complaints successfully fetched.", ['complaints' => $complaints]) : Response::errorResponse("No complaints found.");
        } catch (Throwable $error) {
            return Response::errorResponse($error->getMessage());
        }
    }
    public function getComplaint($req)
    {
        $expectedKeys = ['id'];
        $req = Data::filterData($req, $expectedKeys);
        try {
            Data::onlyNum("ID", $req['id'] ?? null);

            //TRY TO GET COMPLAINT BY ID
            $complaint = $this->getComplaintIfExists($req['id']);
            return Response::successResponseWithData("Complaint successfully fetched.", ['complaint' => $complaint]);
        } catch (Throwable $error) {
            return Response::errorResponse($error->getMessage());
        }
    }
    public function addComplaint($req)
    {
        $expectedKeys = ['description'];
        $req =  Data::filterData($req, $expectedKeys);
        try {
            Data::onlyAlphaNum("Description", $req['description'] ?? null);
            $this->isComplaintDescriptionExists($req['description']);

            //TRY TO ADD COMPLAINT
            $result = $this->complaintModel->addComplaint(...array_values($req));
            $this->generateLog($result, "Add Complaint template", "A new complaint template added \"" . $req['description'] . "\". Complaint ID = " . $result);
            return $result ? Response::successResponse("Complaint successfully added.") : Response::errorResponse("Complaint failed to add.");
        } catch (Throwable $error) {
            return Response::errorResponse($error->getMessage());
        }
    }
    public function updateComplaint($req)
    {
        $expectedKeys = ['id', 'description'];
        $req =  Data::filterData($req, $expectedKeys);
        try {
            Data::onlyNum("ID", $req['id'] ?? null);
            $oldComplaint = $this->getComplaintIfExists($req['id']);

            $newData =  Data::mergeData($oldComplaint, $req);
            Data::onlyAlphaNum("Description", $newData['description']);
            $this->isComplaintDescriptionExists($req['description']);
            //TRY TO UPDATE COMPLAINT
            $result = $this->complaintModel->updateComplaint(...array_values($newData));
            $this->generateLog($result, "Update Complaint template", "Complaint template \"" . $oldComplaint['description'] . "\" updated to \"" . $req['description'] . "\". Complaint ID = " . $req['id']);
            return $result ? Response::successResponse("Complaint successfully updated.") : Response::errorResponse("Complaint failed to update.");
        } catch (Throwable $error) {
            return Response::errorResponse($error->getMessage());
        }
    }
    public function deleteComplaint($req)
    {
        $expectedKeys = ['id'];
        $req =  Data::filterData($req, $expectedKeys);
        try {
            Data::onlyNum("ID", $req['id'] ?? null);
            $complaint = $this->getComplaintIfExists($req['id']);

            //TRY TO DELETE COMPLAINT
            $result = $this->complaintModel->deleteComplaint($req['id']);
            $this->generateLog($result, "Delete Complaint template", "Complaint template \"" . $complaint['description'] . "\" deleted. Complaint ID = " . $req['id']);
            return $result ? Response::successResponse("Complaint successfully deleted.") : Response::errorResponse("Complaint failed to delete.");
        } catch (Throwable $error) {
            return Response::errorResponse($error->getMessage());
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
