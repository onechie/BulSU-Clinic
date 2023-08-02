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

    public function getTreatments()
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
    public function getTreatment(int $id)
    {
        $sql = 'SELECT * FROM treatments WHERE id = :id';

        $pdo = $this->connect();

        try {
            $stmt = $pdo->prepare($sql);
            $params = [
                ':id' => $id,
            ];
            $stmt->execute($params);
            $treatment = $stmt->fetch();
            return $treatment;
        } catch (PDOException $error) {
            throw new Exception('Database error: ' . $error->getMessage());
        }
    }
    public function addTreatment(string $description)
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
                throw new Exception('Error while adding the treatment.');
            }
        } catch (PDOException $error) {
            throw new Exception('Database error: ' . $error->getMessage());
        }
    }
    public function updateTreatment(int $id, string $description)
    {
        $sql = 'UPDATE treatments SET description = :description WHERE id = :id';

        $pdo = $this->connect();

        try {
            $stmt = $pdo->prepare($sql);
            $params = [
                ':id' => $id,
                ':description' => $description,
            ];

            if ($stmt->execute($params)) {
                return true;
            } else {
                throw new Exception('Error while updating the treatment.');
            }
        } catch (PDOException $error) {
            throw new Exception('Database error: ' . $error->getMessage());
        }
    }
    public function deleteTreatment(int $id)
    {
        $sql = 'DELETE FROM treatments WHERE id = :id';

        $pdo = $this->connect();

        try {
            $stmt = $pdo->prepare($sql);
            $params = [
                ':id' => $id,
            ];

            if ($stmt->execute($params)) {
                return true;
            } else {
                throw new Exception('Error while deleting the treatment.');
            }
        } catch (PDOException $error) {
            throw new Exception('Database error: ' . $error->getMessage());
        }
    }

    //CUSTOM METHODS
    public function getTreatmentByDescription(string $description)
    {
        $sql = 'SELECT * FROM treatments WHERE description = :description';

        $pdo = $this->connect();

        try {
            $stmt = $pdo->prepare($sql);
            $params = [
                ':description' => $description,
            ];
            $stmt->execute($params);
            $treatment = $stmt->fetch();
            return $treatment;
        } catch (PDOException $error) {
            throw new Exception('Database error: ' . $error->getMessage());
        }
    }

}