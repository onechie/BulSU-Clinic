<?php
// Check if the file is being directly accessed via URL
require_once("../utils/utility.php");
Utility::preventDirectAccess();
class summarizationController extends Utility
{
    private $medicineModel;
    public function __construct(MedicineModel $medicineModel)
    {
        $this->medicineModel = $medicineModel;
    }

    public function getMedicines(): array
    {
        try {
            $medicines = $this->medicineModel->getAllMedicines();

            return $this->successResponseWithData("Medicines successfully fetched.", ['medicines' => $medicines]);
        } catch (Exception $error) {
            return $this->errorResponse("Error: Unable to fetch medicines.");
        }
    }
}
