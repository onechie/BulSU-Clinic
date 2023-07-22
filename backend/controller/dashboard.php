<?php
//TODO
class DashboardController
{
    private $medicineModel;

    public function __construct(MedicineModel $medicineModel)
    {
        $this->medicineModel = $medicineModel;
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

    private function successResponseWithData(string $message, array $data): array
    {
        return ['success' => true, 'message' => $message] + $data;
    }

    private function errorResponse(string $message): array
    {
        return ['success' => false, 'message' => $message];
    }
}
