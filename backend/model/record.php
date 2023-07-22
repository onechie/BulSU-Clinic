<?php 
class RecordTableInitializer extends DatabaseInitializer
{
    public function __construct()
    {
        $tableName = 'records';
        $columns = [
            'sYear INT NOT NULL',
            'name VARCHAR(255) NOT NULL',
            'date DATE NOT NULL',
            'complaint TEXT NOT NULL',
            'medication VARCHAR(255) NOT NULL',
            'quantity INT NOT NULL',
            'treatment TEXT',
            'laboratory TEXT',
            'bloodPressure VARCHAR(255)',
            'pulse VARCHAR(255)',
            'weight VARCHAR(255)',
            'temperature VARCHAR(255)',
            'respiration VARCHAR(255)',
            'oximetry VARCHAR(255)',
        ];

        parent::__construct($tableName, $columns);
    }
}

class RecordModel extends RecordTableInitializer
{
    public function __construct()
    {
        parent::__construct();
    }

    public function createRecord($schoolYear, $name, $date, $complaint, $medication, $quantity, $treatment, $laboratory, $bloodPressure, $pulse, $weight, $temperature, $respiration, $oximetry)
    {
        $sql = 'INSERT INTO records (sYear, name, date, complaint, medication, quantity, treatment, laboratory, bloodPressure, pulse, weight, temperature, respiration, oximetry) VALUES (:sYear, :name, :date, :complaint, :medication, :quantity, :treatment, :laboratory, :bloodPressure, :pulse, :weight, :temperature, :respiration, :oximetry)';

        $pdo = $this->connect();

        try {
            $stmt = $pdo->prepare($sql);
            $params = [
                ':sYear' => $schoolYear,
                ':name' => $name,
                ':date' => $date,
                ':complaint' => $complaint,
                ':medication' => $medication,
                ':quantity' => $quantity,
                ':treatment' => $treatment,
                ':laboratory' => $laboratory,
                ':bloodPressure' => $bloodPressure,
                ':pulse' => $pulse,
                ':weight' => $weight,
                ':temperature' => $temperature,
                ':respiration' => $respiration,
                ':oximetry' => $oximetry,
            ];

            if ($stmt->execute($params)) {
                return $pdo->lastInsertId();
            } else {
                throw new Exception('Error while creating the record.');
            }
        } catch (PDOException $error) {
            throw new Exception('Database error: ' . $error->getMessage());
        }
    }

    public function getAllRecords()
    {
        $sql = 'SELECT * FROM records';

        $pdo = $this->connect();

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $records = $stmt->fetchAll();
            return $records;
        } catch (PDOException $error) {
            throw new Exception('Database error: ' . $error->getMessage());
        }
    }

    public function getRecordsByName($name)
    {
        $sql = 'SELECT * FROM records WHERE name LIKE :name';

        $pdo = $this->connect();

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':name', "%$name%", PDO::PARAM_STR);
            $stmt->execute();
            $records = $stmt->fetchAll();
            return $records;
        } catch (PDOException $error) {
            throw new Exception('Database error: ' . $error->getMessage());
        }
    }

    public function getRecordById($id)
    {
        $sql = 'SELECT * FROM records WHERE id = :id';

        $pdo = $this->connect();

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $record = $stmt->fetch();
            return $record;
        } catch (PDOException $error) {
            throw new Exception('Database error: ' . $error->getMessage());
        }
    }
}
