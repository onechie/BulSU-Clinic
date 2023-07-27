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
            return $medicines ? $this->successResponseWithData("Medicines successfully fetched.", ['medicines' => $medicines]) : $this->errorResponse("No medicines found.");
        } catch (Throwable $error) {
            return $this->errorResponse($error->getMessage());
        }
    }
    public function getMedicine($req)
    {
        $expectedKeys = ['id'];
        $req = $this->filterData($req, $expectedKeys);
        try {
            $this->onlyNum("ID", $req['id'] ?? null);

            //TRY TO GET MEDICINE BY ID
            $medicine = $this->getMedicineIfExists($req['id']);
            return $this->successResponseWithData("Medicine successfully fetched.", ['medicine' => $medicine]);
        } catch (Throwable $error) {
            return $this->errorResponse($error->getMessage());
        }
    }
    public function addMedicine($req)
    {
        $expectedKeys = ['name', 'brand', 'unit', 'expiration', 'boxesCount', 'itemsPerBox', 'itemsCount', 'storage'];
        $req = $this->filterData($req, $expectedKeys);
        try {
            $this->validateMedicineData($req);
            $this->isMedicineNameExists($req['name']);

            //TRY TO ADD MEDICINE
            $result = $this->medicineModel->addMedicine(...array_values($req));
            return $result ? $this->successResponse("Medicine successfully added.") : $this->errorResponse("Medicine failed to add.");
        } catch (Throwable $error) {
            return $this->errorResponse($error->getMessage());
        }
    }
    public function updateMedicine($req)
    {
        $expectedKeys = ['id', 'name', 'brand', 'unit', 'expiration', 'boxesCount', 'itemsPerBox', 'itemsCount', 'itemsDeducted', 'storage'];
        $req = $this->filterData($req, $expectedKeys);
        try {
            $this->onlyNum("ID", $req['id'] ?? null);
            $oldMedicine = $this->getMedicineIfExists($req['id']);

            $newData = $this->mergeData($oldMedicine, $req);
            $this->validateMedicineData($newData);

            //TRY TO UPDATE MEDICINE
            $result = $this->medicineModel->updateMedicine(...array_values($newData));
            return $result ? $this->successResponse("Medicine successfully updated.") : $this->errorResponse("Medicine failed to update.");
        } catch (Throwable $error) {
            return $this->errorResponse($error->getMessage());
        }
    }

    public function deleteMedicine($req)
    {
        $expectedKeys = ['id'];
        $req = $this->filterData($req, $expectedKeys);
        try {
            $this->onlyNum("ID", $req['id'] ?? null);
            $this->getMedicineIfExists($req['id']);

            //TRY TO DELETE MEDICINE
            $result = $this->medicineModel->deleteMedicine($req['id']);
            return $result ? $this->successResponse("Medicine successfully deleted.") : $this->errorResponse("Medicine failed to delete.");
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
        
        $this->onlyDate("Expiration date", $expiration);
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
    private function isMedicineNameExists($name)
    {
        $medicine = $this->medicineModel->getMedicineByName($name);
        if ($medicine) {
            throw new Exception("Medicine name already exists.");
        }
    }
    private function getMedicineIfExists($id)
    {
        $medicine = $this->medicineModel->getMedicine($id);
        if (!$medicine) throw new Exception("Medicine does not exist.");
        return $medicine;
    }
}
