<?php
// Check if the file is being directly accessed via URL
require_once("../utils/utility.php");
Utility::preventDirectAccess();
class ComplaintTableInitializer extends DatabaseInitializer
{
    public function __construct()
    {
        $tableName = 'complaints';
        $columns = [
            'description TEXT NOT NULL',
        ];

        parent::__construct($tableName, $columns);
    }
}

class ComplaintModel extends ComplaintTableInitializer
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getComplaints()
    {
        $sql = 'SELECT * FROM complaints';

        $pdo = $this->connect();

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $complaints = $stmt->fetchAll();
            return $complaints;
        } catch (PDOException $error) {
            throw new Exception('Database error: ' . $error->getMessage());
        }
    }
    public function getComplaint(int $id)
    {
        $sql = 'SELECT * FROM complaints WHERE id = :id';

        $pdo = $this->connect();

        try {
            $stmt = $pdo->prepare($sql);
            $params = [
                ':id' => $id,
            ];
            $stmt->execute($params);
            $complaint = $stmt->fetch();
            return $complaint;
        } catch (PDOException $error) {
            throw new Exception('Database error: ' . $error->getMessage());
        }
    }
    public function addComplaint(string $description)
    {
        $sql = 'INSERT INTO complaints (description) VALUES (:description)';

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
    public function updateComplaint(int $id, string $description)
    {
        $sql = 'UPDATE complaints SET description = :description WHERE id = :id';

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
                throw new Exception('Error while updating the complaint.');
            }
        } catch (PDOException $error) {
            throw new Exception('Database error: ' . $error->getMessage());
        }
    }
    public function deleteComplaint(int $id)
    {
        $sql = 'DELETE FROM complaints WHERE id = :id';

        $pdo = $this->connect();

        try {
            $stmt = $pdo->prepare($sql);
            $params = [
                ':id' => $id,
            ];

            if ($stmt->execute($params)) {
                return true;
            } else {
                throw new Exception('Error while deleting the complaint.');
            }
        } catch (PDOException $error) {
            throw new Exception('Database error: ' . $error->getMessage());
        }
    }

    // CUSTOM METHODS
    public function getComplaintByDescription(string $description)
    {
        $sql = 'SELECT * FROM complaints WHERE description = :description';

        $pdo = $this->connect();

        try {
            $stmt = $pdo->prepare($sql);
            $params = [
                ':description' => $description,
            ];
            $stmt->execute($params);
            $complaint = $stmt->fetch();
            return $complaint;
        } catch (PDOException $error) {
            throw new Exception('Database error: ' . $error->getMessage());
        }
    }

}
