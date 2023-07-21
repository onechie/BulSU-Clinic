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

    public function addMedicine($name, $brand, $unit, $expiration, $boxesCount, $itemsPerBox, $currentItemsCount)
    {
        $sql = 'INSERT INTO medicines (name, brand, unit, expiration, boxesC, itemsPerB, itemsC) VALUES (:name, :brand, :unit, :expiration, :boxesC, :itemsPerB, :itemsC)';

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
        $sql = 'SELECT name, brand, unit, expiration, boxesC, itemsPerB, itemsC, itemsD FROM medicines';

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
}
