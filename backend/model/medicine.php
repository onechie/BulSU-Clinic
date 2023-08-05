<?php
// Check if the file is being directly accessed via URL
require_once("../middleware/accessMiddleware.php");
Access::preventDirectAccess();
class MedicineTableInitializer extends DatabaseInitializer
{
    public function __construct()
    {
        $tableName = 'medicines';
        $columns = [
            'name VARCHAR(255) NOT NULL',
            'brand VARCHAR(255) NOT NULL',
            'unit VARCHAR(255) NOT NULL',
            'expiration DATE NOT NULL',
            'boxesCount INT NOT NULL',
            'itemsPerBox INT NOT NULL',
            'itemsCount INT NOT NULL',
            'itemsDeducted INT NOT NULL DEFAULT 0',
            'storage VARCHAR(255) NOT NULL',
        ];

        parent::__construct($tableName, $columns);
    }
}

class MedicineModel extends MedicineTableInitializer
{
    public function __construct()
    {
        parent::__construct();
    }

    // NEW METHODS
    public function getMedicines()
    {
        $sql = 'SELECT * FROM medicines';

        $pdo = $this->connect();

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $medicines = $stmt->fetchAll();
            return $medicines;
        } catch (PDOException $error) {
            throw new Exception('Database error: ' . $error->getMessage());
        }
    }
    public function getMedicine(int $id)
    {
        $sql = 'SELECT * FROM medicines WHERE id = :id';

        $pdo = $this->connect();

        try {
            $stmt = $pdo->prepare($sql);
            $params = [
                ':id' => $id,
            ];
            $stmt->execute($params);
            $medicine = $stmt->fetch();
            return $medicine;
        } catch (PDOException $error) {
            throw new Exception('Database error: ' . $error->getMessage());
        }
    }
    public function addMedicine(string $name, string $brand, string $unit, string $expiration, int $boxesCount, int $itemsPerBox, int $itemsCount, string $storage)
    {
        $sql = 'INSERT INTO medicines (name, brand, unit, expiration, boxesCount, itemsPerBox, itemsCount, storage) VALUES (:name, :brand, :unit, :expiration, :boxesCount, :itemsPerBox, :itemsCount, :storage)';

        $pdo = $this->connect();

        try {
            $stmt = $pdo->prepare($sql);
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

            if ($stmt->execute($params)) {
                return true;
            } else {
                throw new Exception('Error while adding the medicine.');
            }
        } catch (PDOException $error) {
            throw new Exception('Database error: ' . $error->getMessage());
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

        $pdo = $this->connect();

        try {
            $stmt = $pdo->prepare($sql);
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

            if ($stmt->execute($params)) {
                return true;
            } else {
                throw new Exception('Error while updating the medicine.');
            }
        } catch (PDOException $error) {
            throw new Exception('Database error: ' . $error->getMessage());
        }
    }

    public function deleteMedicine(int $id)
    {
        $sql = 'DELETE FROM medicines WHERE id = :id';

        $pdo = $this->connect();

        try {
            $stmt = $pdo->prepare($sql);
            $params = [
                ':id' => $id,
            ];

            if ($stmt->execute($params)) {
                return true;
            } else {
                throw new Exception('Error while deleting the medicine.');
            }
        } catch (PDOException $error) {
            throw new Exception('Database error: ' . $error->getMessage());
        }
    }

    // CUSTOM METHODS
    public function getMedicineByName(string $name)
    {
        $sql = 'SELECT * FROM medicines WHERE name = :name';

        $pdo = $this->connect();

        try {
            $stmt = $pdo->prepare($sql);
            $params = [
                ':name' => $name,
            ];
            $stmt->execute($params);
            $medicine = $stmt->fetch();
            return $medicine;
        } catch (PDOException $error) {
            throw new Exception('Database error: ' . $error->getMessage());
        }
    }
}
