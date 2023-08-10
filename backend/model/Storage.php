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

        $pdo = $this->connect();

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $storages = $stmt->fetchAll();
            return $storages;
        } catch (PDOException $error) {
            throw new Exception('Database error: ' . $error->getMessage());
        }
    }
    public function getStorage(int $id)
    {
        $sql = 'SELECT * FROM storages WHERE id = :id';

        $pdo = $this->connect();

        try {
            $stmt = $pdo->prepare($sql);
            $params = [
                ':id' => $id,
            ];
            $stmt->execute($params);
            $storage = $stmt->fetch();
            return $storage;
        } catch (PDOException $error) {
            throw new Exception('Database error: ' . $error->getMessage());
        }
    }
    public function addStorage(string $description)
    {
        $sql = 'INSERT INTO storages (description) VALUES (:description)';

        $pdo = $this->connect();

        try {
            $stmt = $pdo->prepare($sql);
            $params = [
                ':description' => $description,
            ];

            if ($stmt->execute($params)) {
                return true;
            } else {
                throw new Exception('Error while adding the storages.');
            }
        } catch (PDOException $error) {
            throw new Exception('Database error: ' . $error->getMessage());
        }
    }
    public function updateStorage(int $id, string $description)
    {
        $sql = 'UPDATE storages SET description = :description WHERE id = :id';

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
                throw new Exception('Error while updating the storage.');
            }
        } catch (PDOException $error) {
            throw new Exception('Database error: ' . $error->getMessage());
        }
    }
    public function deleteStorage(int $id)
    {
        $sql = 'DELETE FROM storages WHERE id = :id';

        $pdo = $this->connect();

        try {
            $stmt = $pdo->prepare($sql);
            $params = [
                ':id' => $id,
            ];

            if ($stmt->execute($params)) {
                return true;
            } else {
                throw new Exception('Error while deleting the storage.');
            }
        } catch (PDOException $error) {
            throw new Exception('Database error: ' . $error->getMessage());
        }
    }

    // CUSTOM METHODS
    public function getStorageByDescription(string $description)
    {
        $sql = 'SELECT * FROM storages WHERE description = :description';

        $pdo = $this->connect();

        try {
            $stmt = $pdo->prepare($sql);
            $params = [
                ':description' => $description,
            ];
            $stmt->execute($params);
            $storage = $stmt->fetch();
            return $storage;
        } catch (PDOException $error) {
            throw new Exception('Database error: ' . $error->getMessage());
        }
    }
}
