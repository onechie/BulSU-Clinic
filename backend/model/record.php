<?php
class RecordModel extends Database
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getRecords()
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

    public function getRecord(int $id)
    {
        $sql = 'SELECT * FROM records WHERE id = :id';

        $pdo = $this->connect();

        try {
            $stmt = $pdo->prepare($sql);
            $params = [
                ':id' => $id,
            ];
            $stmt->execute($params);
            $record = $stmt->fetch();
            return $record;
        } catch (PDOException $error) {
            throw new Exception('Database error: ' . $error->getMessage());
        }
    }

    public function addRecord(int $schoolYear, string $name, string $date, string $complaint, string $medication, int $quantity, string $treatment, string $laboratory, string $bloodPressure, string $pulse, string $weight, string $temperature, string $respiration, string $oximetry)
    {
        $sql = 'INSERT INTO records (schoolYear, name, date, complaint, medication, quantity, treatment, laboratory, bloodPressure, pulse, weight, temperature, respiration, oximetry) VALUES (:schoolYear, :name, :date, :complaint, :medication, :quantity, :treatment, :laboratory, :bloodPressure, :pulse, :weight, :temperature, :respiration, :oximetry)';

        $pdo = $this->connect();

        try {
            $stmt = $pdo->prepare($sql);
            $params = [
                ':schoolYear' => $schoolYear,
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

    public function updateRecord(int $id, int $schoolYear, string $name, string $date, string $complaint, string $medication, int $quantity, string $treatment, string $laboratory, string $bloodPressure, string $pulse, string $weight, string $temperature, string $respiration, string $oximetry)
    {
        $sql = 'UPDATE records SET schoolYear = :schoolYear, name = :name, date = :date, complaint = :complaint, medication = :medication, quantity = :quantity, treatment = :treatment, laboratory = :laboratory, bloodPressure = :bloodPressure, pulse = :pulse, weight = :weight, temperature = :temperature, respiration = :respiration, oximetry = :oximetry WHERE id = :id';
        $pdo = $this->connect();

        try {
            $stmt = $pdo->prepare($sql);
            $params = [
                ':schoolYear' => $schoolYear,
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
                'temperature' => $temperature,
                ':respiration' => $respiration,
                ':oximetry' => $oximetry,
                ':id' => $id,
            ];
            if ($stmt->execute($params)) {
                return true;
            } else {
                throw new Exception('Error while updating the record.');
            }
        } catch (PDOException $error) {
            throw new Exception('Database error: ' . $error->getMessage());
        }
    }
    public function deleteRecord(int $id)
    {
        $sql = 'DELETE FROM records WHERE id = :id';
        $pdo = $this->connect();

        try {
            $stmt = $pdo->prepare($sql);
            $params = [
                ':id' => $id,
            ];
            if ($stmt->execute($params)) {
                return true;
            } else {
                throw new Exception('Error while deleting the record.');
            }
        } catch (PDOException $error) {
            throw new Exception('Database error: ' . $error->getMessage());
        }
    }

    //CUSTOM METHODS

}
