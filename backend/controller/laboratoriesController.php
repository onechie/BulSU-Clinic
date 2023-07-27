<?php
// Check if the file is being directly accessed via URL
require_once("../utils/utility.php");
Utility::preventDirectAccess();

class LaboratoriesController extends Utility
{
    private $laboratoryModel;
    public function __construct(LaboratoryModel $laboratoryModel)
    {
        $this->laboratoryModel = $laboratoryModel;
    }
    public function getLaboratories()
    {
        try {
            //TRY TO GET ALL LABORATORIES
            $laboratories = $this->laboratoryModel->getLaboratories();
            return $laboratories ? $this->successResponseWithData("Laboratories successfully fetched.", ['laboratories' => $laboratories]) : $this->errorResponse("No laboratories found.");
        } catch (Exception $error) {
            return $this->errorResponse($error->getMessage());
        }
    }
    public function getLaboratory($req)
    {
        $expectedKeys = ['id'];
        $req = $this->filterData($req, $expectedKeys);
        try {
            $this->onlyNum("ID", $req['id'] ?? null);

            //TRY TO GET LABORATORY BY ID
            $laboratory = $this->getLaboratoryIfExists($req['id']);
            return $this->successResponseWithData("Laboratory successfully fetched.", ['laboratory' => $laboratory]);
        } catch (Exception $error) {
            return $this->errorResponse($error->getMessage());
        }
    }
    public function addLaboratory($req)
    {
        $expectedKeys = ['description'];
        $req = $this->filterData($req, $expectedKeys);
        try {
            $this->onlyAlphaNum("Description", $req['description'] ?? null);
            $this->isLaboratoryDescriptionExists($req['description']);

            //TRY TO ADD LABORATORY
            $result = $this->laboratoryModel->addLaboratory(...array_values($req));
            return $result ? $this->successResponse("Laboratory successfully added.") : $this->errorResponse("Laboratory failed to add.");
        } catch (Exception $error) {
            return $this->errorResponse($error->getMessage());
        }
    }
    public function updateLaboratory($req)
    {
        $expectedKeys = ['id', 'description'];
        $req = $this->filterData($req, $expectedKeys);
        try {
            $this->onlyNum("ID", $req['id'] ?? null);
            $oldLaboratory = $this->getLaboratoryIfExists($req['id']);

            $newData = $this->mergeData($oldLaboratory, $req);
            $this->onlyAlphaNum("Description", $newData['description']);

            //TRY TO UPDATE LABORATORY
            $result = $this->laboratoryModel->updateLaboratory(...array_values($newData));
            return $result ? $this->successResponse("Laboratory successfully updated.") : $this->errorResponse("Laboratory failed to update.");
        } catch (Exception $error) {
            return $this->errorResponse($error->getMessage());
        }
    }
    public function deleteLaboratory($req)
    {
        $expectedKeys = ['id'];
        $req = $this->filterData($req, $expectedKeys);
        try {
            $this->onlyNum("ID", $req['id'] ?? null);
            $this->getLaboratoryIfExists($req['id']);

            //TRY TO DELETE LABORATORY
            $result = $this->laboratoryModel->deleteLaboratory($req['id']);
            return $result ? $this->successResponse("Laboratory successfully deleted.") : $this->errorResponse("Laboratory failed to delete.");
        } catch (Exception $error) {
            return $this->errorResponse($error->getMessage());
        }
    }
    private function isLaboratoryDescriptionExists($description)
    {
        $laboratory = $this->laboratoryModel->getLaboratoryByDescription($description);
        if ($laboratory) throw new Exception("Laboratory already exists.");
    }
    private function getLaboratoryIfExists($id)
    {
        $laboratory = $this->laboratoryModel->getLaboratory($id);
        if (!$laboratory) throw new Exception("Laboratory does not exist.");
        return $laboratory;
    }
}