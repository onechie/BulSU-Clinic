<?php
class LaboratoryTableInitializer extends DatabaseInitializer
{
    public function __construct()
    {
        $tableName = 'laboratories';
        $columns = [
            'description TEXT NOT NULL',
        ];

        parent::__construct($tableName, $columns);
    }
}

class LaboratoryModel extends LaboratoryTableInitializer
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getLaboratories()
    {
        $sql = 'SELECT * FROM laboratories';

        $pdo = $this->connect();

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $laboratories = $stmt->fetchAll();
            return $laboratories;
        } catch (PDOException $error) {
            throw new Exception('Database error: ' . $error->getMessage());
        }
    }
    public function getLaboratory(int $id)
    {
        $sql = 'SELECT * FROM laboratories WHERE id = :id';

        $pdo = $this->connect();

        try {
            $stmt = $pdo->prepare($sql);
            $params = [
                ':id' => $id,
            ];
            $stmt->execute($params);
            $laboratory = $stmt->fetch();
            return $laboratory;
        } catch (PDOException $error) {
            throw new Exception('Database error: ' . $error->getMessage());
        }
    }
    public function addLaboratory(string $description)
    {
        $sql = 'INSERT INTO laboratories (description) VALUES (:description)';

        $pdo = $this->connect();

        try {
            $stmt = $pdo->prepare($sql);
            $params = [
                ':description' => $description,
            ];

            if ($stmt->execute($params)) {
                return true;
            } else {
                throw new Exception('Error while adding the laboratory.');
            }
        } catch (PDOException $error) {
            throw new Exception('Database error: ' . $error->getMessage());
        }
    }
    public function updateLaboratory(int $id, string $description)
    {
        $sql = 'UPDATE laboratories SET description = :description WHERE id = :id';

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
                throw new Exception('Error while updating the laboratory.');
            }
        } catch (PDOException $error) {
            throw new Exception('Database error: ' . $error->getMessage());
        }
    }
    public function deleteLaboratory(int $id)
    {
        $sql = 'DELETE FROM laboratories WHERE id = :id';

        $pdo = $this->connect();

        try {
            $stmt = $pdo->prepare($sql);
            $params = [
                ':id' => $id,
            ];

            if ($stmt->execute($params)) {
                return true;
            } else {
                throw new Exception('Error while deleting the laboratory.');
            }
        } catch (PDOException $error) {
            throw new Exception('Database error: ' . $error->getMessage());
        }
    }

    //CUSTOM METHODS
    public function getLaboratoryByDescription(string $description)
    {
        $sql = 'SELECT * FROM laboratories WHERE description = :description';

        $pdo = $this->connect();

        try {
            $stmt = $pdo->prepare($sql);
            $params = [':description' => $description];
            $stmt->execute($params);
            $laboratory = $stmt->fetch();
            return $laboratory;
        } catch (PDOException $error) {
            throw new Exception('Database error: ' . $error->getMessage());
        }
    }
}
