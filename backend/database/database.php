<?php
abstract class Database
{
    private static $connection = null;
    private $servername = 'localhost';
    private $username = 'root';
    private $password = '';
    private $dbname = 'bulsuclinic';
    protected $tableName;

    public function __construct(string $tableName)
    {
        $this->tableName = $tableName;
    }

    protected function createTable(PDO $pdo) {
        // Define the SQL query to create the "users" table
        // ...
    }

    protected function getPdo(): PDO
    {
        if (self::$connection === null) {
            try {
                $dsn = 'mysql:host=' . $this->servername . ';dbname=' . $this->dbname;
                self::$connection = new PDO($dsn, $this->username, $this->password);
                self::$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $error) {
                throw new Exception('Database connection error: ' . $error->getMessage());
            }
        }

        return self::$connection;
    }

    protected function checkAndCreateTable()
    {
        $pdo = $this->getPdo();
        if (!$this->checkTableExists($pdo)) {
            $this->createTable($pdo);
        }
    }

    protected function checkTableExists(PDO $pdo): bool
    {
        $sql = "SHOW TABLES LIKE :table";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':table', $this->tableName, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }
}
