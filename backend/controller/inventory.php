<?php
class InventoryController extends Utility
{
    private $medicineModel;
    private $storageModel;
    public function __construct(MedicineModel $medicineModel, StorageModel $storageModel)
    {
        $this->medicineModel = $medicineModel;
        $this->storageModel = $storageModel;
    }

    public function getFormSuggestions(): array
    {
        $suggestions = [
            "storages" => $this->storageModel->getAllStorages(),
        ];
        return $this->successResponseWithData("Form suggestions successfully retrieved.", $suggestions);
    }

    public function createMedicine(array $medicineData): array
    {
        $name = $medicineData['name'] ?? '';
        $brand = $medicineData['brand'] ?? '';
        $unit = $medicineData['unit'] ?? '';
        $expiration = $medicineData['expiration'] ?? '';
        $boxesCount = $medicineData['boxesCount'] ?? '';
        $itemsPerBox = $medicineData['itemsPerBox'] ?? '';
        $itemsCount = $medicineData['itemsCount'] ?? '';
        $storage = $medicineData['storage'] ?? '';

        if (empty($name) || empty($brand) || empty($unit) || empty($expiration) || empty($boxesCount) || empty($itemsPerBox) || empty($itemsCount) || empty($storage)) {
            return $this->errorResponse("All fields are required.");
        }

        $isStorageExists = $this->storageModel->getStorage($storage);
        if (!$isStorageExists) {
            return $this->errorResponse("Storage does not exist.");
        }

        if (!is_string($name) || !is_string($brand) || !is_string($unit)) {
            return $this->errorResponse("Name, brand, or unit is invalid.");
        }

        $expirationDate = DateTime::createFromFormat('Y-m-d', $expiration);
        if (!$expirationDate || $expirationDate < new DateTime()) {
            return $this->errorResponse("Invalid or expired expiration date.");
        }

        if (!is_numeric($boxesCount) || !is_numeric($itemsPerBox) || !is_numeric($itemsCount)) {
            return $this->errorResponse("Box/Item count must be numbers.");
        }

        $result = $this->medicineModel->addMedicine($name, $brand, $unit, $expiration, $boxesCount, $itemsPerBox, $itemsCount, $storage);

        if ($result) {
            return $this->successResponse("Medicine created successfully.");
        } else {
            return $this->errorResponse("Internal Error: Unable to create medicine.");
        }
    }

    public function getAllMedicine(): array
    {
        try {
            $medicines = $this->medicineModel->getAllMedicines();

            return $this->successResponseWithData("Medicines successfully fetched.", ['medicines' => $medicines]);
        } catch (Exception $error) {
            return $this->errorResponse("Error: Unable to fetch medicines.");
        }
    }
}
