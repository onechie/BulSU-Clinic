<?php

class TreatmentsController
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

            //TRY TO UPDATE TREATMENT
            $result = $this->treatmentModel->updateTreatment(...array_values($newData));
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
            $this->getTreatmentIfExists($req['id']);

            //TRY TO DELETE TREATMENT
            $result = $this->treatmentModel->deleteTreatment($req['id']);
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
}
