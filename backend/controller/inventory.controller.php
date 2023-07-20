<?php
class InventoryController
{
    private $medicineModel;

    public function __construct(MedicineModel $medicineModel)
    {
        $this->medicineModel = $medicineModel;
    }
    public function createMedicine($medicineData)
    {
        // Get the necessary data from the $medicineData array
        $name = $medicineData['name'];
        $brand = $medicineData['brand'];
        $unit = $medicineData['unit'];
        $expiration = $medicineData['expiration'];
        $boxesC = $medicineData['boxesCount'];
        $itemsPerB = $medicineData['itemsPerBox'];
        $itemsC = $medicineData['itemsCount'];

        // Initialize the response array
        $response = [];

        // Validate the data types
        if (!is_string($name) || !is_string($brand) || !is_string($unit)) {
            $response['success'] = false;
            $response['message'] = "Name, brand, or unit is invalid.";
            return $response;
        }

        if (!DateTime::createFromFormat('Y-m-d', $expiration)) {
            $response['success'] = false;
            $response['message'] = "Invalid expiration date.";
            return $response;
        }

        if (!is_numeric($boxesC)  || !is_numeric($itemsPerB)  || !is_numeric($itemsC)) {
            $response['success'] = false;
            $response['message'] = "Box/Item count must be numbers.";
            return $response;
        }

        // Call the MedicineModel's setMedicine method for database insertion
        $result = $this->medicineModel->setMedicine($name, $brand, $unit, $expiration, $boxesC, $itemsPerB, $itemsC);

        // Set the response based on the result of the setMedicine method
        if ($result) {
            $response['success'] = true;
            $response['message'] = "Medicine created successfully.";
        } else {
            $response['success'] = false;
            $response['message'] = "Internal Error: Unable to create medicine.";
        }

        return $response;
    }
    public function getAllMedicine()
    {
        // Initialize the response array
        $response = [];

        try {
            // Call the MedicineModel's getMedicine method to fetch all medicines
            $medicines = $this->medicineModel->getMedicine();

            // Set the response with the fetched medicines
            $response['success'] = true;
            $response['message'] = "Medicines successfully get";
            $response['medicines'] = $medicines;
        } catch (Exception $error) {
            // Handle any exceptions that occur during the fetch
            $response['success'] = false;
            $response['message'] = "Error: Unable to fetch medicines.";
        }

        return $response;
    }
}
