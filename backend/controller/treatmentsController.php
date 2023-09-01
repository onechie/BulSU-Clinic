<?php

class TreatmentsController
{
    private $treatmentModel;
    private $logModel;
    public function __construct(TreatmentModel $treatmentModel, LogModel $logModel)
    {
        $this->treatmentModel = $treatmentModel;
        $this->logModel = $logModel;
    }
    public function getTreatments()
    {
        try {
            //TRY TO GET ALL TREATMENTS
            $treatments = $this->treatmentModel->getTreatments();
            return $treatments ? Response::successResponseWithData("Treatments successfully fetched.", ['treatments' => $treatments]) : Response::errorResponse("No treatments found.");
        } catch (Throwable $error) {
            return Response::errorResponse($error->getMessage());
        }
    }
    public function getTreatment($req)
    {
        $expectedKeys = ['id'];
        $req = Data::filterData($req, $expectedKeys);
        try {
            Data::onlyNum("ID", $req['id'] ?? null);

            //TRY TO GET TREATMENT BY ID
            $treatment = $this->getTreatmentIfExists($req['id']);
            return Response::successResponseWithData("Treatment successfully fetched.", ['treatment' => $treatment]);
        } catch (Throwable $error) {
            return Response::errorResponse($error->getMessage());
        }
    }
    public function addTreatment($req)
    {
        $expectedKeys = ['description'];
        $req = Data::filterData($req, $expectedKeys);
        try {
            Data::onlyAlphaNum("Description", $req['description'] ?? null);
            $this->isTreatmentDescriptionExists($req['description']);

            //TRY TO ADD TREATMENT
            $treatment = $this->treatmentModel->addTreatment($req['description']);
            $this->generateLog($treatment, "Add Treatment template", "A new treatment template added \"" . $req['description'] . "\". Treatment ID = " . $treatment);
            return $treatment ? Response::successResponse("Treatment successfully added.") : Response::errorResponse("Treatment failed to add.");
        } catch (Throwable $error) {
            return Response::errorResponse($error->getMessage());
        }
    }
    public function updateTreatment($req)
    {
        $expectedKeys = ['id', 'description'];
        $req = Data::filterData($req, $expectedKeys);
        try {
            Data::onlyNum("ID", $req['id'] ?? null);
            $oldTreatment = $this->getTreatmentIfExists($req['id']);

            $newData = Data::mergeData($oldTreatment, $req);
            Data::onlyAlphaNum("Description", $newData['description']);
            $this->isTreatmentDescriptionExists($req['description']);
            //TRY TO UPDATE TREATMENT
            $result = $this->treatmentModel->updateTreatment(...array_values($newData));
            $this->generateLog($result, "Update Treatment template", "Treatment template \"" . $oldTreatment['description'] . "\" updated to \"" . $req['description'] . "\". Treatment ID = " . $req['id']);
            return $result ? Response::successResponse("Treatment successfully updated.") : Response::errorResponse("Treatment failed to update.");
        } catch (Throwable $error) {
            return Response::errorResponse($error->getMessage());
        }
    }
    public function deleteTreatment($req)
    {
        $expectedKeys = ['id'];
        $req = Data::filterData($req, $expectedKeys);
        try {
            Data::onlyNum("ID", $req['id'] ?? null);
            $treatment = $this->getTreatmentIfExists($req['id']);

            //TRY TO DELETE TREATMENT
            $result = $this->treatmentModel->deleteTreatment($req['id']);
            $this->generateLog($result, "Delete Treatment template", "Treatment template \"" . $treatment['description'] . "\" deleted. Treatment ID = " . $req['id']);
            return $result ? Response::successResponse("Treatment successfully deleted.") : Response::errorResponse("Treatment failed to delete.");
        } catch (Throwable $error) {
            return Response::errorResponse($error->getMessage());
        }
    }
    private function isTreatmentDescriptionExists($description)
    {
        $treatment = $this->treatmentModel->getTreatmentByDescription($description);
        if ($treatment) throw new Exception("Treatment already exists.");
    }
    private function getTreatmentIfExists($id)
    {
        $treatment = $this->treatmentModel->getTreatment($id);
        if (!$treatment) throw new Exception("Treatment does not exist.");
        return $treatment;
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
