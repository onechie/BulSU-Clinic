<?php
// Check if the file is being directly accessed via URL
require_once("../utils/utility.php");
Utility::preventDirectAccess();

class TreatmentsController extends Utility
{
    private $treatmentModel;
    public function __construct(TreatmentModel $treatmentModel)
    {
        $this->treatmentModel = $treatmentModel;
    }
    public function getTreatments()
    {
        try {
            //TRY TO GET ALL TREATMENTS
            $treatments = $this->treatmentModel->getTreatments();
            return $treatments ? $this->successResponseWithData("Treatments successfully fetched.", ['treatments' => $treatments]) : $this->errorResponse("No treatments found.");
        } catch (Throwable $error) {
            return $this->errorResponse($error->getMessage());
        }
    }
    public function getTreatment($req)
    {
        $expectedKeys = ['id'];
        $req = $this->filterData($req, $expectedKeys);
        try {
            $this->onlyNum("ID", $req['id'] ?? null);

            //TRY TO GET TREATMENT BY ID
            $treatment = $this->getTreatmentIfExists($req['id']);
            return $this->successResponseWithData("Treatment successfully fetched.", ['treatment' => $treatment]);
        } catch (Throwable $error) {
            return $this->errorResponse($error->getMessage());
        }
    }
    public function addTreatment($req)
    {
        $expectedKeys = ['description'];
        $req = $this->filterData($req, $expectedKeys);
        try {
            $this->onlyAlphaNum("Description", $req['description'] ?? null);
            $this->isTreatmentDescriptionExists($req['description']);

            //TRY TO ADD TREATMENT
            $treatment = $this->treatmentModel->addTreatment($req['description']);
            return $treatment ? $this->successResponse("Treatment successfully added.") : $this->errorResponse("Treatment failed to add.");
        } catch (Throwable $error) {
            return $this->errorResponse($error->getMessage());
        }
    }
    public function updateTreatment($req)
    {
        $expectedKeys = ['id', 'description'];
        $req = $this->filterData($req, $expectedKeys);
        try {
            $this->onlyNum("ID", $req['id'] ?? null);
            $oldTreatment = $this->getTreatmentIfExists($req['id']);

            $newData = $this->mergeData($oldTreatment, $req);
            $this->onlyAlphaNum("Description", $newData['description']);

            //TRY TO UPDATE TREATMENT
            $result = $this->treatmentModel->updateTreatment(...array_values($newData));
            return $result ? $this->successResponse("Treatment successfully updated.") : $this->errorResponse("Treatment failed to update.");
        } catch (Throwable $error) {
            return $this->errorResponse($error->getMessage());
        }
    }
    public function deleteTreatment($req)
    {
        $expectedKeys = ['id'];
        $req = $this->filterData($req, $expectedKeys);
        try {
            $this->onlyNum("ID", $req['id'] ?? null);
            $this->getTreatmentIfExists($req['id']);

            //TRY TO DELETE TREATMENT
            $result = $this->treatmentModel->deleteTreatment($req['id']);
            return $result ? $this->successResponse("Treatment successfully deleted.") : $this->errorResponse("Treatment failed to delete.");
        } catch (Throwable $error) {
            return $this->errorResponse($error->getMessage());
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
}