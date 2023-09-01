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
        try {
            return $this->db_read_all($sql);
        } catch (Throwable $error) {
            throw new Exception($error->getMessage());
        }
    }

    public function getRecord(int $id)
    {
        $sql = 'SELECT * FROM records WHERE id = :id';
        $params = [
            ':id' => $id,
        ];
        try {
            return $this->db_read($sql, $params);
        } catch (Throwable $error) {
            throw new Exception($error->getMessage());
        }
    }

    public function addRecord(int $schoolYear, string $name, string $date, string $complaint, string $medication, int $quantity, string $treatment, string $laboratory, string $bloodPressure, string $pulse, string $weight, string $temperature, string $respiration, string $oximetry, string $userCreated)
    {
        $sql = 'INSERT INTO records (schoolYear, name, date, complaint, medication, quantity, treatment, laboratory, bloodPressure, pulse, weight, temperature, respiration, oximetry, userCreated) VALUES (:schoolYear, :name, :date, :complaint, :medication, :quantity, :treatment, :laboratory, :bloodPressure, :pulse, :weight, :temperature, :respiration, :oximetry, :userCreated)';
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
            ':userCreated' => $userCreated,
        ];
        try {
            return $this->db_create($sql, $params, true);
        } catch (Throwable $error) {
            throw new Exception($error->getMessage());
        }
    }

    public function updateRecord(int $id, int $schoolYear, string $name, string $date, string $complaint, string $medication, int $quantity, string $treatment, string $laboratory, string $bloodPressure, string $pulse, string $weight, string $temperature, string $respiration, string $oximetry)
    {
        $sql = 'UPDATE records SET schoolYear = :schoolYear, name = :name, date = :date, complaint = :complaint, medication = :medication, quantity = :quantity, treatment = :treatment, laboratory = :laboratory, bloodPressure = :bloodPressure, pulse = :pulse, weight = :weight, temperature = :temperature, respiration = :respiration, oximetry = :oximetry WHERE id = :id';
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

        try {
            return $this->db_update($sql, $params);
        } catch (Throwable $error) {
            throw new Exception($error->getMessage());
        }
    }
    public function deleteRecord(int $id)
    {
        $sql = 'DELETE FROM records WHERE id = :id';
        $params = [
            ':id' => $id,
        ];
        try {
            return $this->db_delete($sql, $params);
        } catch (Throwable $error) {
            throw new Exception($error->getMessage());
        }
    }

    //CUSTOM METHODS

    public function getRecordsByPatientName(string $name)
    {
        $sql = 'SELECT * FROM records WHERE name = :name';
        $params = [
            ':name' => $name,
        ];
        try {
            return $this->db_read_all($sql, $params);
        } catch (Throwable $error) {
            throw new Exception($error->getMessage());
        }
    }
}
