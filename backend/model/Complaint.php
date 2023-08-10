<?php
class ComplaintModel extends Database
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getComplaints()
    {
        $sql = 'SELECT * FROM complaints';
        try {
            return $this->db_read_all($sql);
        } catch (Throwable $error) {
            throw new Exception($error->getMessage());
        }
    }
    public function getComplaint(int $id)
    {
        $sql = 'SELECT * FROM complaints WHERE id = :id';
        $params = [
            ':id' => $id,
        ];
        try {
            return $this->db_read($sql, $params);
        } catch (Throwable $error) {
            throw new Exception($error->getMessage());
        }
    }
    public function addComplaint(string $description)
    {
        $sql = 'INSERT INTO complaints (description) VALUES (:description)';
        $params = [
            ':description' => $description,
        ];
        try {
            return $this->db_create($sql, $params);
        } catch (Throwable $error) {
            throw new Exception($error->getMessage());
        }
    }
    public function updateComplaint(int $id, string $description)
    {
        $sql = 'UPDATE complaints SET description = :description WHERE id = :id';
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
    public function deleteComplaint(int $id)
    {
        $sql = 'DELETE FROM complaints WHERE id = :id';
        $params = [
            ':id' => $id,
        ];
        try {
            return $this->db_delete($sql, $params);
        } catch (Throwable $error) {
            throw new Exception($error->getMessage());
        }
    }

    // CUSTOM METHODS
    public function getComplaintByDescription(string $description)
    {
        $sql = 'SELECT * FROM complaints WHERE description = :description';
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
