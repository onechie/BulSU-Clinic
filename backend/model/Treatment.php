<?php
// Check if the file is being directly accessed via URL
require_once("../utils/utility.php");
Utility::preventDirectAccess();
class TreatmentTableInitializer extends DatabaseInitializer
{
    public function __construct()
    {
        $tableName = 'treatments';
        $columns = [
            'description TEXT NOT NULL',
        ];

        parent::__construct($tableName, $columns);
    }
}

class TreatmentModel extends TreatmentTableInitializer
{
    public function __construct()
    {
        parent::__construct();
    }

    public function addTreatment($description)
    {
        $sql = 'INSERT INTO treatments (description) VALUES (:description)';

        $pdo = $this->connect();

        try {
            $stmt = $pdo->prepare($sql);
            $params = [
                ':description' => $description,
            ];

            if ($stmt->execute($params)) {
                return true;
            } else {
                throw new Exception('Error while adding the complaint.');
            }
        } catch (PDOException $error) {
            throw new Exception('Database error: ' . $error->getMessage());
        }
    }
    public function getAllTreatments()
    {
        $sql = 'SELECT * FROM treatments';

        $pdo = $this->connect();

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $treatments = $stmt->fetchAll();
            return $treatments;
        } catch (PDOException $error) {
            throw new Exception('Database error: ' . $error->getMessage());
        }
    }
    public function getTreatment($description)
    {
        $sql = 'SELECT * FROM treatments WHERE description = :description';

        $pdo = $this->connect();

        try {
            $stmt = $pdo->prepare($sql);
            $params = [':description' => $description];
            $stmt->execute($params);
            $treatment = $stmt->fetch();
            return $treatment;
        } catch (PDOException $error) {
            throw new Exception('Database error: ' . $error->getMessage());
        }
    }
    public function deleteTreatment($id)
    {
        $sql = 'DELETE FROM treatments WHERE id = :id';

        $pdo = $this->connect();

        try {
            $stmt = $pdo->prepare($sql);
            $params = [':id' => $id];
            $stmt->execute($params);
            return true;
        } catch (PDOException $error) {
            throw new Exception('Database error: ' . $error->getMessage());
        }
    }
}
