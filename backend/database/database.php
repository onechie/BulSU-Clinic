<?php

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__, "../../.env");
$dotenv->load();
class Database
{
    private static $connection = null;
    private $server_name;
    private $username;
    private $password;
    private $dbname;


    public function __construct()
    {
        $this->server_name = $_ENV['DB_HOST'] ?? '';
        $this->username = $_ENV['DB_USER'] ?? '';
        $this->password = $_ENV['DB_PASSWORD'] ?? '';
        $this->dbname = $_ENV['DB_NAME'] ?? '';
    }

    protected function connect(): PDO
    {
        try {
            if (self::$connection === null) {
                $dsn = 'mysql:host=' . $this->server_name . ';dbname=' . $this->dbname;
                $options = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ];
                self::$connection = new PDO($dsn, $this->username, $this->password, $options);
            }
            return self::$connection;
        } catch (PDOException $error) {
            throw new Exception('DATABASE ERROR: ' . $error->getMessage());
        }
    }
    protected function db_read_all($sql, $params = [])
    {
        $pdo = $this->connect();
        try {
            $stmt = $pdo->prepare($sql);
            if ($params) {
                $stmt->execute($params);
            } else {
                $stmt->execute();
            }
            $stmt->execute();
            $data = $stmt->fetchAll();
            return $data;
        } catch (PDOException $error) {
            throw new Exception('DATABASE ERROR: ' . $error->getMessage());
        }
    }
    protected function db_read($sql, $params)
    {
        $pdo = $this->connect();
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            $attachment = $stmt->fetch();
            return $attachment;
        } catch (PDOException $error) {
            throw new Exception('DATABASE ERROR: ' . $error->getMessage());
        }
    }
    protected function db_create($sql, $params, $return_id = false)
    {
        $pdo = $this->connect();
        try {
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute($params)) {
                if ($return_id) {
                    return $pdo->lastInsertId();
                } else {
                    return true;
                }
            } else {
                throw new Exception('Error occurred while inserting data.');
            }
        } catch (PDOException $error) {
            throw new Exception('DATABASE ERROR: ' . $error->getMessage());
        }
    }
    protected function db_update($sql, $params)
    {
        $pdo = $this->connect();
        try {
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute($params)) {
                return true;
            } else {
                throw new Exception('Error occurred while updating data.');
            }
        } catch (PDOException $error) {
            throw new Exception('DATABASE ERROR: ' . $error->getMessage());
        }
    }
    protected function db_delete($sql, $params)
    {
        $pdo = $this->connect();
        try {
            $stmt = $pdo->prepare($sql);

            if ($stmt->execute($params)) {
                return true;
            } else {
                throw new Exception('Error occurred while deleting data.');
            }
        } catch (PDOException $error) {
            throw new Exception('DATABASE ERROR: ' . $error->getMessage());
        }
    }
}
