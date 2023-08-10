<?php 
require_once 'database.php';
class Initializer extends Database
{
    private $tableName;
    private $columns;

    public function __construct(string $tableName, array $columns)
    {
        $this->tableName = $tableName;
        $this->columns = $columns;
        parent::__construct();
        $this->initialize();
    }

    protected function createTable(PDO $pdo)
    {
        $columnDefinitions = implode(",\n", $this->columns);

        $sql = "
            CREATE TABLE IF NOT EXISTS $this->tableName (
                id INT AUTO_INCREMENT PRIMARY KEY,
                $columnDefinitions,
                created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )
        ";
        try {
            $pdo->exec($sql);
        } catch (PDOException $error) {
            throw new Exception('DATABASE ERROR: ' . $error->getMessage());
        }
    }

    public function initialize()
    {
        try {
            $pdo = $this->connect();
            if (!$this->tableExists($pdo)) $this->createTable($pdo);
        } catch (PDOException $error) {
            throw new Exception('DATABASE ERROR: ' . $error->getMessage());
        }
    }

    protected function tableExists(PDO $pdo): bool
    {
        $stmt = $pdo->prepare("SHOW TABLES LIKE :table");
        $stmt->execute([':table' => $this->tableName]);
        return $stmt->rowCount() > 0;
    }
}