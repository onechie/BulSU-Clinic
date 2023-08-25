<?php
class MedicinesController
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
            return $medicines ? Response::successResponseWithData("Medicines successfully fetched.", ['medicines' => $medicines]) : Response::errorResponse("No medicines found.");
        } catch (Throwable $error) {
            return Response::errorResponse($error->getMessage());
        }
    }
    public function getMedicine($req)
    {
        $expectedKeys = ['id'];
        $req = Data::filterData($req, $expectedKeys);
        try {
            Data::onlyNum("ID", $req['id'] ?? null);

            //TRY TO GET MEDICINE BY ID
            $medicine = $this->getMedicineIfExists($req['id']);
            return Response::successResponseWithData("Medicine successfully fetched.", ['medicine' => $medicine]);
        } catch (Throwable $error) {
            return Response::errorResponse($error->getMessage());
        }
    }
    public function addMedicine($req)
    {
        $expectedKeys = ['name', 'brand', 'unit', 'expiration', 'boxesCount', 'itemsPerBox', 'itemsCount', 'storage'];
        $req = Data::filterData($req, $expectedKeys);
        try {
            $this->validateMedicineData($req);
            $this->isMedicineNameExists($req['name']);

            //TRY TO ADD MEDICINE
            $result = $this->medicineModel->addMedicine(...array_values($req));
            return $result ? Response::successResponse("Medicine successfully added.") : Response::errorResponse("Medicine failed to add.");
        } catch (Throwable $error) {
            return Response::errorResponse($error->getMessage());
        }
    }
    public function updateMedicine($req)
    {
        $expectedKeys = ['id', 'name', 'brand', 'unit', 'expiration', 'boxesCount', 'itemsPerBox', 'itemsCount', 'storage'];
        $req = Data::filterData($req, $expectedKeys);
        try {
            Data::onlyNum("ID", $req['id'] ?? null);
            $oldMedicine = $this->getMedicineIfExists($req['id']);
            $req = Data::fillMissingDataKeys($req, $expectedKeys);
            $newData = Data::mergeData($oldMedicine, $req);
            $this->validateMedicineData($newData);

            //TRY TO UPDATE MEDICINE
            $result = $this->medicineModel->updateMedicine(...array_values($newData));
            return $result ? Response::successResponse("Medicine successfully updated.") : Response::errorResponse("Medicine failed to update.");
        } catch (Throwable $error) {
            return Response::errorResponse($error->getMessage());
        }
    }

    public function deleteMedicine($req)
    {
        $expectedKeys = ['id'];
        $req = Data::filterData($req, $expectedKeys);
        try {
            Data::onlyNum("ID", $req['id'] ?? null);
            $this->getMedicineIfExists($req['id']);

            //TRY TO DELETE MEDICINE
            $result = $this->medicineModel->deleteMedicine($req['id']);
            return $result ? Response::successResponse("Medicine successfully deleted.") : Response::errorResponse("Medicine failed to delete.");
        } catch (Throwable $error) {
            return Response::errorResponse($error->getMessage());
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

        Data::onlyAlphaNum("Medicine name", $name);
        Data::onlyAlphaNum("Brand", $brand);
        Data::onlyAlphaNum("Unit", $unit);

        // $this->onlyDate("Expiration date", $expiration);
        // if ($expiration < date("Y-m-d")) {
        //     throw new Exception("Expiration date must be greater than or equal to today.");
        // }

        Data::onlyDate("Expiration date", $expiration);
        $today = new DateTime();
        $expirationDate = new DateTime($expiration);
        if ($expirationDate < $today) {
            throw new Exception("The expiration date must be later than today's date.");
        }

        Data::onlyNum("Count of boxes", strval($boxesCount));
        if ($boxesCount < 1) {
            throw new Exception("Count of boxes must be greater than or equal to 1.");
        }

        Data::onlyNum("Items per box", strval($itemsPerBox));
        if ($itemsPerBox < 1) {
            throw new Exception("Items per box must be greater than or equal to 1.");
        }

        Data::onlyNum("Total items", strval($itemsCount));
        if ($itemsCount < 1) {
            throw new Exception("Total items must be greater than or equal to 1.");
        }

        if (isset($medicineData['itemsDeducted'])) {
            $itemsDeducted = $medicineData['itemsDeducted'];
            Data::onlyNum("Items deducted", strval($itemsDeducted), true);
            if ($itemsCount < $itemsDeducted) {
                throw new Exception("Total items must be greater than or equal to dispensed items.");
            }
        }

        Data::onlyAlphaNum("Storage", $storage);
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
