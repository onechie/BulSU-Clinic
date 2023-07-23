<?php
class StorageTableInitializer extends DatabaseInitializer
{
    public function __construct()
    {
        $tableName = 'storages';
        $columns = [
            'description TEXT NOT NULL',
        ];

        parent::__construct($tableName, $columns);
    }
}

class StorageModel extends StorageTableInitializer
{
    public function __construct()
    {
        parent::__construct();
    }

    public function addStorage($description)
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
                throw new Exception('Error while adding the complaint.');
            }
        } catch (PDOException $error) {
            throw new Exception('Database error: ' . $error->getMessage());
        }
    }
    public function getAllStorages()
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
    public function getStorage($description)
    {
        $sql = 'SELECT * FROM storages WHERE description = :description';

        $pdo = $this->connect();

        try {
            $stmt = $pdo->prepare($sql);
            $params = [':description' => $description];
            $stmt->execute($params);
            $storage = $stmt->fetch();
            return $storage;
        } catch (PDOException $error) {
            throw new Exception('Database error: ' . $error->getMessage());
        }
    }
    public function deleteStorage($id)
    {
        $sql = 'DELETE FROM storages WHERE id = :id';

        $pdo = $this->connect();

        try {
            $stmt = $pdo->prepare($sql);
            $params = [':id' => $id];
            $stmt->execute($params);
            return true;
        } catch (PDOException $error) {
            throw new Exception('Database error: ' . $error->getMessage());
        }
    }
}
