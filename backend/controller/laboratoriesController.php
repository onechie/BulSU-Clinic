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
            if (!$laboratories) {
                return $this->errorResponse("No laboratories found.");
            }
            return $this->successResponseWithData("Laboratories successfully fetched.", ['laboratories' => $laboratories]);
        } catch (Exception $error) {
            return $this->errorResponse($error->getMessage());
        }
    }
    public function getLaboratory($req)
    {
        $expectedKeys = ['id'];
        try {
            //REMOVE UNEXPECTED KEY VALUE PAIRS
            $req = array_intersect_key($req, array_flip($expectedKeys));

            //INPUT VALIDATION
            $this->onlyNum("ID", $req['id'] ?? null);

            //TRY TO GET LABORATORY BY ID
            $laboratory = $this->laboratoryModel->getLaboratory($req['id']);
            if (!$laboratory) {
                return $this->errorResponse("Laboratory does not exist.");
            }
            return $this->successResponseWithData("Laboratory successfully fetched.", ['laboratory' => $laboratory]);
        } catch (Exception $error) {
            return $this->errorResponse($error->getMessage());
        }
    }
    public function addLaboratory($req)
    {
        $expectedKeys = ['description'];
        try {
            //REMOVE UNEXPECTED KEY VALUE PAIRS
            $req = array_intersect_key($req, array_flip($expectedKeys));

            //INPUT VALIDATION
            $this->onlyAlphaNum("Description", $req['description'] ?? null);

            //CHECK IF LABORATORY ALREADY EXISTS
            $this->laboratoryDescriptionExists($req['description']);

            //TRY TO ADD LABORATORY
            $result = $this->laboratoryModel->addLaboratory(...array_values($req));
            if (!$result) {
                return $this->errorResponse("Laboratory failed to add.");
            }
            return $this->successResponse("Laboratory successfully added.");
        } catch (Exception $error) {
            return $this->errorResponse($error->getMessage());
        }
    }

    public function updateLaboratory($req)
    {
        $expectedKeys = ['id', 'description'];
        try {
            //REMOVE UNEXPECTED KEY VALUE PAIRS
            $req = array_intersect_key($req, array_flip($expectedKeys));

            //INPUT VALIDATION
            $this->onlyNum("ID", $req['id'] ?? null);

            //CHECK IF LABORATORY EXISTS
            $oldLaboratory = $this->laboratoryModel->getLaboratory($req['id']);
            if (!$oldLaboratory) {
                throw new Exception("Laboratory does not exist.");
            }

            //REMOVE EMPTY ARRAY VALUES TO PREPARE FOR MERGE
            $req = array_filter($req, function ($value) {
                return !empty($value);
            });

            //MERGE OLD LABORATORY DATA WITH NEW LABORATORY DATA ONLY
            $newLaboratoryData = array_merge($oldLaboratory, $req);

            //CHECK IF THERE ARE ANY CHANGES
            $differences = array_diff_assoc($oldLaboratory, $newLaboratoryData);
            if (empty($differences)) {
                return $this->errorResponse("No changes were made.");
            }

            //INPUT VALIDATION
            $this->onlyAlphaNum("Description", $newLaboratoryData['description']);

            //TRY TO UPDATE LABORATORY
            $result = $this->laboratoryModel->updateLaboratory(...array_values($newLaboratoryData));
            if (!$result) {
                return $this->errorResponse("Laboratory failed to update.");
            }
            return $this->successResponse("Laboratory successfully updated.");
        } catch (Exception $error) {
            return $this->errorResponse($error->getMessage());
        }
    }

    public function deleteLaboratory($req)
    {
        $expectedKeys = ['id'];
        try {
            //REMOVE UNEXPECTED KEY VALUE PAIRS
            $req = array_intersect_key($req, array_flip($expectedKeys));

            //INPUT VALIDATION
            $this->onlyNum("ID", $req['id'] ?? null);

            //CHECK IF LABORATORY EXISTS
            $laboratory = $this->laboratoryModel->getLaboratory($req['id']);
            if (!$laboratory) {
                return $this->errorResponse("Laboratory does not exist.");
            }

            //TRY TO DELETE LABORATORY
            $result = $this->laboratoryModel->deleteLaboratory($req['id']);
            if (!$result) {
                return $this->errorResponse("Laboratory failed to delete.");
            }
            return $this->successResponse("Laboratory successfully deleted.");
        } catch (Exception $error) {
            return $this->errorResponse($error->getMessage());
        }
    }

    private function laboratoryDescriptionExists($description)
    {
        $result = $this->laboratoryModel->getLaboratoryByDescription($description);
        if ($result) {
            throw new Exception("Laboratory already exists.");
        }
    }
}
