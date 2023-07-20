<?php
class RecordModel extends Database
{
    public function __construct()
    {
        parent::__construct('records'); // Pass the table name as a string here
        $this->checkAndCreateTable();
    }

    protected function createTable(PDO $pdo)
    {
        // Define the SQL query to create the "records" table
        $sql = "
            CREATE TABLE IF NOT EXISTS records (
                id INT AUTO_INCREMENT PRIMARY KEY,
                sYear INT NOT NULL,
                name VARCHAR(255) NOT NULL,
                date DATE NOT NULL,
                complaint TEXT,
                medication VARCHAR(255),
                quantity INT,
                treatment TEXT,
                laboratory TEXT,
                bloodPressure VARCHAR(255),
                pulse VARCHAR(255),
                weight VARCHAR(255),
                temperature VARCHAR(255),
                respiration VARCHAR(255),
                oximetry VARCHAR(255),
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

    public function setRecord($sYear, $name, $date, $complaint, $medication, $quantity, $treatment, $laboratory, $bloodPressure, $pulse, $weight, $temperature, $respiration, $oximetry)
    {
        // Prepare the SQL query with positional placeholders (?)
        $sql = 'INSERT INTO records (sYear, name, date, complaint, medication, quantity, treatment, laboratory, bloodPressure, pulse, weight, temperature, respiration, oximetry) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';

        // Get the PDO connection from the parent class
        $pdo = $this->getPdo();

        try {
            // Prepare the statement
            $stmt = $pdo->prepare($sql);

            // Bind the values to the placeholders and execute the statement
            if (!$stmt->execute([$sYear, $name, $date, $complaint, $medication, $quantity, $treatment, $laboratory, $bloodPressure, $pulse, $weight, $temperature, $respiration, $oximetry])) {
                return false;
            } else {
                return $pdo->lastInsertId(); // Return the ID of the newly inserted record
            }
        } catch (PDOException $error) {
            // Handle any exceptions that occur during the insertion
            return false;
        }
    }

    public function getRecord()
    {
        // Prepare the SQL query to retrieve all records
        $sql = 'SELECT name, complaint, date, medication FROM records';

        // Get the PDO connection from the parent class
        $pdo = $this->getPdo();

        try {
            // Prepare the statement
            $stmt = $pdo->prepare($sql);

            // Execute the statement
            $stmt->execute();

            // Fetch all the record data as an associative array
            $records = $stmt->fetchAll();

            // Return the array of records
            return $records;
        } catch (PDOException $error) {
            // Handle any exceptions that occur during the query
            return false;
        }
    }
    public function getRecordsByName($name)
    {
        // Prepare the SQL query to retrieve records by name
        $sql = 'SELECT id, date, complaint, medication FROM records WHERE name LIKE :name';

        // Get the PDO connection from the parent class
        $pdo = $this->getPdo();

        try {
            // Prepare the statement
            $stmt = $pdo->prepare($sql);

            // Bind the name parameter to the query
            $stmt->bindValue(':name', "%$name%", PDO::PARAM_STR);

            // Execute the statement
            $stmt->execute();

            // Fetch all the record data as an associative array
            $records = $stmt->fetchAll();

            // Return the array of records
            return $records;
        } catch (PDOException $error) {
            // Handle any exceptions that occur during the query
            return false;
        }
    }
    public function getRecordById($id)
    {
        // Prepare the SQL query to retrieve a record by its ID
        $sql = 'SELECT * FROM records WHERE id = :id';

        // Get the PDO connection from the parent class
        $pdo = $this->getPdo();

        try {
            // Prepare the statement
            $stmt = $pdo->prepare($sql);

            // Bind the ID parameter to the query
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);

            // Execute the statement
            $stmt->execute();

            // Fetch the record data as an associative array
            $record = $stmt->fetch();

            // Return the record data
            return $record;
        } catch (PDOException $error) {
            // Handle any exceptions that occur during the query
            return false;
        }
    }
}
