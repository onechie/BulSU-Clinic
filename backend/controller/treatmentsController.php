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
            if (!$treatments) {
                return $this->errorResponse("No treatments found.");
            }
            return $this->successResponseWithData("Treatments successfully fetched.", ['treatments' => $treatments]);
        } catch (Exception $error) {
            return $this->errorResponse($error->getMessage());
        }
    }
    public function getTreatment($req)
    {
        $expectedKeys = ['id'];
        try {
            //REMOVE UNEXPECTED KEY VALUE PAIRS
            $req = array_intersect_key($req, array_flip($expectedKeys));

            //INPUT VALIDATION
            $this->onlyNum("ID", $req['id'] ?? null);

            //TRY TO GET TREATMENT BY ID
            $treatment = $this->treatmentModel->getTreatment($req['id']);
            if (!$treatment) {
                return $this->errorResponse("Treatment does not exist.");
            }
            return $this->successResponseWithData("Treatment successfully fetched.", ['treatment' => $treatment]);
        } catch (Exception $error) {
            return $this->errorResponse($error->getMessage());
        }
    }

    public function addTreatment($req)
    {
        $expectedKeys = ['description'];
        try {
            //REMOVE UNEXPECTED KEY VALUE PAIRS
            $req = array_intersect_key($req, array_flip($expectedKeys));

            //INPUT VALIDATION
            $this->onlyAlphaNum("Description", $req['description'] ?? null);

            //CHECK IF TREATMENT ALREADY EXISTS
            $this->treatmentDescriptionExists($req['description']);

            //TRY TO ADD TREATMENT
            $treatment = $this->treatmentModel->addTreatment($req['description']);
            if (!$treatment) {
                return $this->errorResponse("Failed to add treatment.");
            }
            return $this->successResponse("Treatment successfully added.");
        } catch (Exception $error) {
            return $this->errorResponse($error->getMessage());
        }
    }

    public function updateTreatment($req)
    {
        $expectedKeys = ['id', 'description'];
        try {
            //REMOVE UNEXPECTED KEY VALUE PAIRS
            $req = array_intersect_key($req, array_flip($expectedKeys));

            //INPUT VALIDATION
            $this->onlyNum("ID", $req['id'] ?? null);

            //CHECK IF TREATMENT EXISTS
            $oldTreatment = $this->treatmentModel->getTreatment($req['id']);
            if (!$oldTreatment) {
                throw new Exception("Treatment does not exist.");
            }

            //REMOVE EMPTY ARRAY VALUES TO PREPARE FOR MERGE
            $req = array_filter($req, function ($value) {
                return !empty($value);
            });

            //MERGE OLD TREATMENT DATA WITH NEW STORAGE DATA ONLY
            $newTreatmentData = array_merge($oldTreatment, $req);

            //CHECK IF THERE ARE ANY CHANGES
            $differences = array_diff_assoc($oldTreatment, $newTreatmentData);
            if (empty($differences)) {
                return $this->errorResponse("No changes were made.");
            }

            //INPUT VALIDATION
            $this->onlyAlphaNum("Description", $newTreatmentData['description']);

            //TRY TO UPDATE TREATMENT
            $result = $this->treatmentModel->updateTreatment(...array_values($newTreatmentData));
            if (!$result) {
                return $this->errorResponse("Treatment failed to update.");
            }
            return $this->successResponse("Treatment successfully updated.");
        } catch (Exception $error) {
            return $this->errorResponse($error->getMessage());
        }
    }

    public function deleteTreatment($req)
    {
        $expectedKeys = ['id'];
        try {
            //REMOVE UNEXPECTED KEY VALUE PAIRS
            $req = array_intersect_key($req, array_flip($expectedKeys));

            //INPUT VALIDATION
            $this->onlyNum("ID", $req['id'] ?? null);

            //CHECK IF TREATMENT EXISTS
            $treatment = $this->treatmentModel->getTreatment($req['id']);
            if (!$treatment) {
                throw new Exception("Treatment does not exist.");
            }

            //TRY TO DELETE TREATMENT
            $result = $this->treatmentModel->deleteTreatment($req['id']);
            if (!$result) {
                return $this->errorResponse("Treatment failed to delete.");
            }
            return $this->successResponse("Treatment successfully deleted.");
        } catch (Exception $error) {
            return $this->errorResponse($error->getMessage());
        }
    }

    private function treatmentDescriptionExists($description)
    {
        $treatment = $this->treatmentModel->getTreatmentByDescription($description);
        if ($treatment) {
            throw new Exception("Treatment already exists.");
        }
    }
}
