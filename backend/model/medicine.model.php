<?php
class MedicineModel extends Database
{
    public function __construct()
    {
        parent::__construct('medicines'); // Pass the table name as a string here
        $this->checkAndCreateTable();
    }

    protected function createTable(PDO $pdo)
    {
        // Define the SQL query to create the "medicines" table
        $sql = "
        CREATE TABLE IF NOT EXISTS medicines (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            brand VARCHAR(255) NOT NULL,
            unit VARCHAR(255) NOT NULL,
            expiration DATE NOT NULL,
            boxesC INT NOT NULL,
            itemsPerB INT NOT NULL,
            itemsC INT NOT NULL,
            itemsD INT NOT NULL DEFAULT 0,
            created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )
    ";

        // Execute the SQL query to create the table
        try {
            $pdo->exec($sql);
        } catch (PDOException $error) {
            // Handle any exceptions that occur during table creation
            throw new Exception('Database connection error: ' . $error->getMessage());
        }
    }

    public function setMedicine($name, $brand, $unit, $expiration, $boxesC, $itemsPerB, $itemsC)
    {
        // Prepare the SQL query with positional placeholders (?)
        $sql = 'INSERT INTO medicines (name, brand, unit, expiration, boxesC, itemsPerB, itemsC) VALUES (?, ?, ?, ?, ?, ?, ?)';

        // Get the PDO connection from the parent class
        $pdo = $this->getPdo();

        try {
            // Prepare the statement
            $stmt = $pdo->prepare($sql);

            // Bind the values to the placeholders and execute the statement
            if (!$stmt->execute([$name, $brand, $unit, $expiration, $boxesC, $itemsPerB, $itemsC])) {
                return false;
            } else {
                return true;
            }
        } catch (PDOException $error) {
            // Handle any exceptions that occur during the insertion
            return false;
        }
    }


    public function getMedicine()
    {
        // Prepare the SQL query to retrieve all medicines
        $sql = 'SELECT name, brand, unit, expiration, boxesC, itemsPerB, itemsC, itemsD FROM medicines';

        // Get the PDO connection from the parent class
        $pdo = $this->getPdo();

        try {
            // Prepare the statement
            $stmt = $pdo->prepare($sql);

            // Execute the statement
            $stmt->execute();

            // Fetch all the medicine data as an associative array
            $medicines = $stmt->fetchAll();

            // Return the array of medicines
            return $medicines;
        } catch (PDOException $error) {
            // Handle any exceptions that occur during the query
            return false;
        }
    }
}
