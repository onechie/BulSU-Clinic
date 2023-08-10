<?php

class MedicineModel extends Database
{
    public function __construct()
    {
        parent::__construct();
    }
    // NEW METHODS
    public function getMedicines()
    {
        $sql = 'SELECT * FROM medicines';
        try {
            return $this->db_read_all($sql);
        } catch (Throwable $error) {
            throw new Exception($error->getMessage());
        }
    }
    public function getMedicine(int $id)
    {
        $sql = 'SELECT * FROM medicines WHERE id = :id';
        $params = [
            ':id' => $id,
        ];
        try {
            return $this->db_read($sql, $params);
        } catch (Throwable $error) {
            throw new Exception($error->getMessage());
        }
    }
    public function addMedicine(string $name, string $brand, string $unit, string $expiration, int $boxesCount, int $itemsPerBox, int $itemsCount, string $storage)
    {
        $sql = 'INSERT INTO medicines (name, brand, unit, expiration, boxesCount, itemsPerBox, itemsCount, storage) VALUES (:name, :brand, :unit, :expiration, :boxesCount, :itemsPerBox, :itemsCount, :storage)';
        $params = [
            ':name' => $name,
            ':brand' => $brand,
            ':unit' => $unit,
            ':expiration' => $expiration,
            ':boxesCount' => $boxesCount,
            ':itemsPerBox' => $itemsPerBox,
            ':itemsCount' => $itemsCount,
            ':storage' => $storage,
        ];
        try {
            return $this->db_create($sql, $params);
        } catch (Throwable $error) {
            throw new Exception($error->getMessage());
        }
    }

    public function updateMedicine(int $id, string $name, string $brand, string $unit, string $expiration, int $boxesCount, int $itemsPerBox, int $itemsCount, int $itemsDeducted, string $storage)
    {
        $sql = 'UPDATE medicines SET 
        name = :name, 
        brand = :brand, 
        unit = :unit,
        expiration = :expiration,
        boxesCount = :boxesCount,
        itemsPerBox = :itemsPerBox,
        itemsCount = :itemsCount,
        itemsDeducted = :itemsDeducted,
        storage = :storage 
        WHERE id = :id';
        $params = [
            ':name' => $name,
            ':brand' => $brand,
            ':unit' => $unit,
            ':expiration' => $expiration,
            ':boxesCount' => $boxesCount,
            ':itemsPerBox' => $itemsPerBox,
            ':itemsCount' => $itemsCount,
            ':itemsDeducted' => $itemsDeducted,
            ':storage' => $storage,
            ':id' => $id,
        ];
        try {
            return $this->db_update($sql, $params);
        } catch (Throwable $error) {
            throw new Exception($error->getMessage());
        }
    }

    public function deleteMedicine(int $id)
    {
        $sql = 'DELETE FROM medicines WHERE id = :id';
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
    public function getMedicineByName(string $name)
    {
        $sql = 'SELECT * FROM medicines WHERE name = :name';
        $params = [
            ':name' => $name,
        ];
        try {
            return $this->db_read($sql, $params);
        } catch (Throwable $error) {
            throw new Exception($error->getMessage());
        }
    }
}
