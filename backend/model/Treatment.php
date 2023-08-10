<?php

class TreatmentModel extends Database
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getTreatments()
    {
        $sql = 'SELECT * FROM treatments';
        try {
            return $this->db_read_all($sql);
        } catch (Throwable $error) {
            throw new Exception($error->getMessage());
        }
    }
    public function getTreatment(int $id)
    {
        $sql = 'SELECT * FROM treatments WHERE id = :id';
        $params = [
            ':id' => $id,
        ];
        try {
            return $this->db_read($sql, $params);
        } catch (Throwable $error) {
            throw new Exception($error->getMessage());
        }
    }
    public function addTreatment(string $description)
    {
        $sql = 'INSERT INTO treatments (description) VALUES (:description)';
        $params = [
            ':description' => $description,
        ];
        try {
            return $this->db_create($sql, $params);
        } catch (Throwable $error) {
            throw new Exception($error->getMessage());
        }
    }
    public function updateTreatment(int $id, string $description)
    {
        $sql = 'UPDATE treatments SET description = :description WHERE id = :id';
        $params = [
            ':id' => $id,
            ':description' => $description,
        ];
        try {
            return $this->db_update($sql, $params);
        } catch (Throwable $error) {
            throw new Exception($error->getMessage());
        }
    }
    public function deleteTreatment(int $id)
    {
        $sql = 'DELETE FROM treatments WHERE id = :id';
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
    public function getTreatmentByDescription(string $description)
    {
        $sql = 'SELECT * FROM treatments WHERE description = :description';
        $params = [
            ':description' => $description,
        ];
        try {
            return $this->db_read($sql, $params);
        } catch (Throwable $error) {
            throw new Exception($error->getMessage());
        }
    }
}
