<?php
// Check if the file is being directly accessed via URL
require_once("../utils/utility.php");
Utility::preventDirectAccess();

class MedicinesController extends Utility
{
    private $medicineModel;
    private $storageModel;
    public function __construct(MedicineModel $medicineModel, StorageModel $storageModel)
    {
        $this->medicineModel = $medicineModel;
        $this->storageModel = $storageModel;
    }
    public function getMedicines()
    {
        try {
            //TRY TO GET ALL MEDICINES
            $medicines = $this->medicineModel->getMedicines();
            if (!$medicines) {
                return $this->errorResponse("No medicines found.");
            }
            return $this->successResponseWithData("Medicines successfully fetched.", ['medicines' => $medicines]);
        } catch (Throwable $error) {
            return $this->errorResponse($error->getMessage());
        }
    }
    public function getMedicine($req)
    {
        $expectedKeys = ['id'];
        try {
            //REMOVE UNEXPECTED KEY VALUE PAIRS
            $req = array_intersect_key($req, array_flip($expectedKeys));

            //INPUT VALIDATION
            $this->onlyNum("ID", $req['id'] ?? null);
            //TRY TO GET MEDICINE BY ID
            $medicine = $this->medicineModel->getMedicine($req['id']);
            if (!$medicine) {
                return $this->errorResponse("Medicine does not exist.");
            }
            return $this->successResponseWithData("Medicine successfully fetched.", ['medicine' => $medicine]);
        } catch (Throwable $error) {
            return $this->errorResponse($error->getMessage());
        }
    }
    public function addMedicine($req)
    {
        $expectedKeys = ['name', 'brand', 'unit', 'expiration', 'boxesCount', 'itemsPerBox', 'itemsCount', 'storage'];

        try {
            //REMOVE UNEXPECTED KEY VALUE PAIRS
            $req = array_intersect_key($req, array_flip($expectedKeys));

            //INPUT VALIDATION
            $this->validateMedicineData($req);

            //CHECK IF MEDICINE ALREADY EXISTS
            $this->medicineNameExists($req['name']);

            //TRY TO ADD MEDICINE
            $result = $this->medicineModel->addMedicine(...array_values($req));
            if (!$result) {
                return $this->errorResponse("Medicine failed to add.");
            }
            return $this->successResponse("Medicine successfully added.");
        } catch (Throwable $error) {
            return $this->errorResponse($error->getMessage());
        }
    }

    public function updateMedicine($req)
    {
        $expectedKeys = ['id', 'name', 'brand', 'unit', 'expiration', 'boxesCount', 'itemsPerBox', 'itemsCount', 'itemsDeducted', 'storage'];

        try {
            //REMOVE UNEXPECTED KEY VALUE PAIRS
            $req = array_intersect_key($req, array_flip($expectedKeys));

            //INPUT VALIDATION
            $this->onlyNum("ID", $req['id'] ?? null);

            //CHECK IF MEDICINE EXISTS
            $oldMedicine = $this->medicineModel->getMedicine($req['id']);
            if (!$oldMedicine) {
                throw new Exception("Medicine does not exist.");
            }

            //REMOVE EMPTY ARRAY VALUES TO PREPARE FOR MERGE
            $req = array_filter($req, function ($value) {
                return !empty($value);
            });

            //MERGE OLD MEDICINE DATA WITH NEW MEDICINE DATA ONLY
            $newMedicineData = array_merge($oldMedicine, $req);

            //CHECK IF THERE ARE ANY CHANGES
            $differences = array_diff_assoc($oldMedicine, $newMedicineData);
            if (empty($differences)) {
                return $this->errorResponse("No changes were made.");
            }

            //INPUT VALIDATION
            $this->validateMedicineData($newMedicineData);

            //TRY TO UPDATE MEDICINE
            $result = $this->medicineModel->updateMedicine(...array_values($newMedicineData));
            if (!$result) {
                return $this->errorResponse("Medicine failed to update.");
            }
            return $this->successResponse("Medicine successfully updated.");
        } catch (Throwable $error) {
            return $this->errorResponse($error->getMessage());
        }
    }

    public function deleteMedicine($req)
    {
        $expectedKeys = ['id'];
        try {
            //REMOVE UNEXPECTED KEY VALUE PAIRS
            $req = array_intersect_key($req, array_flip($expectedKeys));

            //INPUT VALIDATION
            $this->onlyNum("ID", $req['id'] ?? null);

            //CHECK IF MEDICINE EXISTS
            $medicine = $this->medicineModel->getMedicine($req['id']);
            if (!$medicine) {
                return $this->errorResponse("Medicine does not exist.");
            }

            //TRY TO DELETE MEDICINE
            $result = $this->medicineModel->deleteMedicine($req['id']);
            if (!$result) {
                return $this->errorResponse("Medicine failed to delete.");
            }
            return $this->successResponse("Medicine successfully deleted.");
        } catch (Throwable $error) {
            return $this->errorResponse($error->getMessage());
        }
    }
    private function validateMedicineData(array $medicineData)
    {
        $name = $medicineData['name'] ?? null;
        $brand = $medicineData['brand'] ?? null;
        $unit = $medicineData['unit'] ?? null;
        $expiration = $medicineData['expiration'] ?? null;
        $boxesCount = $medicineData['boxesCount'] ?? null;
        $itemsPerBox = $medicineData['itemsPerBox'] ?? null;
        $itemsCount = $medicineData['itemsCount'] ?? null;
        $storage = $medicineData['storage'] ?? null;

        $this->onlyAlphaNum("Medicine name", $name);
        $this->onlyAlphaNum("Brand", $brand);
        $this->onlyAlphaNum("Unit", $unit);

        // $this->onlyDate("Expiration date", $expiration);
        // if ($expiration < date("Y-m-d")) {
        //     throw new Exception("Expiration date must be greater than or equal to today.");
        // }
        $today = new DateTime();
        $expirationDate = new DateTime($expiration);
        if ($expirationDate < $today) {
            throw new Exception("The expiration date must be later than today's date.");
        }

        $this->onlyNum("Boxes count", strval($boxesCount));
        if ($boxesCount < 1) {
            throw new Exception("Boxes count value must be greater than or equal to 1.");
        }

        $this->onlyNum("Items per box", strval($itemsPerBox));
        if ($itemsPerBox < 1) {
            throw new Exception("Items per box value must be greater than or equal to 1.");
        }

        $this->onlyNum("Items count", strval($itemsCount));
        if ($itemsCount < 1) {
            throw new Exception("Items count value must be greater than or equal to 1.");
        }

        if (isset($medicineData['itemsDeducted'])) {
            $itemsDeducted = $medicineData['itemsDeducted'];
            $this->onlyNum("Items deducted", strval($itemsDeducted), true);
            if ($itemsDeducted > $itemsCount) {
                throw new Exception("Items deducted value must be less than or equal to items count value.");
            }
        }

        $this->onlyAlphaNum("Storage", $storage);
        $storages = $this->storageModel->getStorageByDescription($storage);
        if (!$storages) {
            throw new Exception("Storage does not exist.");
        }
    }
    private function medicineNameExists($name)
    {
        $medicine = $this->medicineModel->getMedicineByName($name);
        if ($medicine) {
            throw new Exception("Medicine name already exists.");
        }
    }
}