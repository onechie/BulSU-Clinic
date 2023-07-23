<?php
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
            'boxesC INT NOT NULL',
            'itemsPerB INT NOT NULL',
            'itemsC INT NOT NULL',
            'itemsD INT NOT NULL DEFAULT 0',
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

    public function addMedicine($name, $brand, $unit, $expiration, $boxesCount, $itemsPerBox, $currentItemsCount, $storage)
    {
        $sql = 'INSERT INTO medicines (name, brand, unit, expiration, boxesC, itemsPerB, itemsC, storage) VALUES (:name, :brand, :unit, :expiration, :boxesC, :itemsPerB, :itemsC, :storage)';

        $pdo = $this->connect();

        try {
            $stmt = $pdo->prepare($sql);
            $params = [
                ':name' => $name,
                ':brand' => $brand,
                ':unit' => $unit,
                ':expiration' => $expiration,
                ':boxesC' => $boxesCount,
                ':itemsPerB' => $itemsPerBox,
                ':itemsC' => $currentItemsCount,
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

    public function getAllMedicines()
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
    public function getMedicineByName($name)
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
    public function updateMedicineById($id, $quantity, $deducted)
    {
        $sql = 'UPDATE medicines SET itemsC = :quantity, itemsD = :deducted WHERE id = :id';

        $pdo = $this->connect();

        try {
            $stmt = $pdo->prepare($sql);
            $params = [
                ':quantity' => $quantity,
                ':deducted' => $deducted,
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
}
