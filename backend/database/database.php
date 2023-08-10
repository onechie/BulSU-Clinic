<?php
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__, "../../.env");
$dotenv->load();
class Database
{
    private static $connection = null;
    private $servername;
    private $username;
    private $password;
    private $dbname;


    public function __construct()
    {
        $this->servername = $_ENV['DB_HOST'] ?? '';
        $this->username = $_ENV['DB_USER'] ?? '';
        $this->password = $_ENV['DB_PASSWORD'] ?? '';
        $this->dbname = $_ENV['DB_NAME'] ?? '';
    }

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