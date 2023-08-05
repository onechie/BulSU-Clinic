<?php
// Check if the file is being directly accessed via URL
require_once("../middleware/accessMiddleware.php");
Access::preventDirectAccess();

class Database
{
    private static $connection = null;
    private $servername = 'localhost';
    private $username = 'root';
    private $password = '';
    private $dbname = 'bulsuclinic';

    protected function connect(): PDO
    {
        if (self::$connection === null) {
            $dsn = 'mysql:host=' . $this->servername . ';dbname=' . $this->dbname;
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ];
            self::$connection = new PDO($dsn, $this->username, $this->password, $options);
        }

        return self::$connection;
    }
}

class DatabaseInitializer extends Database
{
    private $tableName;
    private $columns;

    public function __construct(string $tableName, array $columns)
    {
        $this->tableName = $tableName;
        $this->columns = $columns;
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
            throw new Exception('Table creation error: ' . $error->getMessage());
        }
    }

    public function initialize()
    {
        try {
            $pdo = $this->connect();
            if (!$this->tableExists($pdo)) $this->createTable($pdo);
        } catch (PDOException $error) {
            throw new Exception('Database initialization error: ' . $error->getMessage());
        }
    }

    protected function tableExists(PDO $pdo): bool
    {
        $stmt = $pdo->prepare("SHOW TABLES LIKE :table");
        $stmt->execute([':table' => $this->tableName]);
        return $stmt->rowCount() > 0;
    }
}
