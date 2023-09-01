<?php

class LogModel extends Database
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getLogs()
    {
        $sql = 'SELECT * FROM logs';
        try {
            return $this->db_read_all($sql);
        } catch (Throwable $error) {
            throw new Exception($error->getMessage());
        }
    }
    public function getLog(int $id)
    {
        $sql = 'SELECT * FROM logs WHERE id = :id';
        $params = [
            ':id' => $id,
        ];
        try {
            return $this->db_read($sql, $params);
        } catch (Throwable $error) {
            throw new Exception($error->getMessage());
        }
    }
    public function addLog(int $userId, string $username, string $action, string $description)
    {
        $sql = 'INSERT INTO logs (userId, username, action, description) VALUES (:userId, :username, :action, :description)';
        $params = [
            ':userId' => $userId,
            ':username' => $username,
            ':action' => $action,
            ':description' => $description,
        ];
        try {
            return $this->db_create($sql, $params);
        } catch (Throwable $error) {
            throw new Exception($error->getMessage());
        }
    }
}
