<?php

class StorageModel extends Database
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getStorages()
    {
        $sql = 'SELECT * FROM storages';
        try{
            return $this->db_read_all($sql);
        } catch (Throwable $error) {
            throw new Exception($error->getMessage());
        }
    }
    public function getStorage(int $id)
    {
        $sql = 'SELECT * FROM storages WHERE id = :id';
        $params = [
            ':id' => $id,
        ];
        try {
            return $this->db_read($sql, $params);
        } catch (Throwable $error) {
            throw new Exception($error->getMessage());
        }
    }
    public function addStorage(string $description)
    {
        $sql = 'INSERT INTO storages (description) VALUES (:description)';
        $params = [
            ':description' => $description,
        ];
        try {
            return $this->db_create($sql, $params, true);
        } catch (Throwable $error) {
            throw new Exception($error->getMessage());
        }
    }
    public function updateStorage(int $id, string $description)
    {
        $sql = 'UPDATE storages SET description = :description WHERE id = :id';
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
    public function deleteStorage(int $id)
    {
        $sql = 'DELETE FROM storages WHERE id = :id';
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
    public function getStorageByDescription(string $description)
    {
        $sql = 'SELECT * FROM storages WHERE description = :description';
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
