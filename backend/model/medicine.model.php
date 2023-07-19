<?php
class MedicineModel extends Database
{
    public function __construct()
    {
        parent::__construct('medicines'); // Pass the table name as a string here
    }

    protected function createTable(PDO $pdo) {
        // Define the SQL query to create the "users" table
        $sql = "
            
        ";

        // Execute the SQL query to create the table
        $pdo->exec($sql);
    }
    public function setMedicine($medicineData)
    {
        // Use the connect() method from the parent class to get the database connection
        $pdo = $this->getPdo();

        // Implement the insertMedicine method
        // ...
    }
}
