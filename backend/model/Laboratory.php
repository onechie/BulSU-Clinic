<?php

class LaboratoryModel extends Database
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getLaboratories()
    {
        $sql = 'SELECT * FROM laboratories';
        try {
            return $this->db_read_all($sql);
        } catch (Throwable $error) {
            throw new Exception($error->getMessage());
        }
    }
    public function getLaboratory(int $id)
    {
        $sql = 'SELECT * FROM laboratories WHERE id = :id';
        $params = [
            ':id' => $id,
        ];
        try {
            return $this->db_read($sql, $params);
        } catch (Throwable $error) {
            throw new Exception($error->getMessage());
        }
    }
    public function addLaboratory(string $description)
    {
        $sql = 'INSERT INTO laboratories (description) VALUES (:description)';
        $params = [
            ':description' => $description,
        ];
        try {
            return $this->db_create($sql, $params, true);
        } catch (Throwable $error) {
            throw new Exception($error->getMessage());
        }
    }
    public function updateLaboratory(int $id, string $description)
    {
        $sql = 'UPDATE laboratories SET description = :description WHERE id = :id';
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
    public function deleteLaboratory(int $id)
    {
        $sql = 'DELETE FROM laboratories WHERE id = :id';
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
    public function getLaboratoryByDescription(string $description)
    {
        $sql = 'SELECT * FROM laboratories WHERE description = :description';
        $params = [':description' => $description];
        try {
            return $this->db_read($sql, $params);
        } catch (Throwable $error) {
            throw new Exception($error->getMessage());
        }
    }
}
