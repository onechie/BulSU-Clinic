<?php 
class InventoryController
{
    private $medicineModel;

    public function __construct(MedicineModel $medicineModel)
    {
        $this->medicineModel = $medicineModel;
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

        if (empty($name) || empty($brand) || empty($unit) || empty($expiration) || empty($boxesCount) || empty($itemsPerBox) || empty($itemsCount)) {
            return $this->errorResponse("All fields are required.");
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

        $result = $this->medicineModel->addMedicine($name, $brand, $unit, $expiration, $boxesCount, $itemsPerBox, $itemsCount);

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

    private function successResponse(string $message): array
    {
        return ['success' => true, 'message' => $message];
    }

    private function successResponseWithData(string $message, array $data): array
    {
        return ['success' => true, 'message' => $message] + $data;
    }

    private function errorResponse(string $message): array
    {
        return ['success' => false, 'message' => $message];
    }
}
