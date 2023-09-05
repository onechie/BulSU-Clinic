<?php

class UserModel extends Database
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getUsers()
    {
        $sql = 'SELECT * FROM users';
        try {
            return $this->db_read_all($sql);
        } catch (Throwable $error) {
            throw new Exception($error->getMessage());
        }
    }
    public function getUser(int $id)
    {
        $sql = 'SELECT * FROM users WHERE id = :id';
        $params = [
            ':id' => $id,
        ];
        try {
            return $this->db_read($sql, $params);
        } catch (Throwable $error) {
            throw new Exception($error->getMessage());
        }
    }
    public function addUser(string $username, string $email, string $password)
    {
        $sql = 'INSERT INTO users (username, email, password) VALUES (:username, :email, :password)';

        $params = [
            ':username' => $username,
            ':email' => $email,
            ':password' => $password,
        ];
        try {
            return $this->db_create($sql, $params, true);
        } catch (Throwable $error) {
            throw new Exception($error->getMessage());
        }
    }
    public function updateUser(int $id, string $username, string $email, string $password)
    {
        $sql = 'UPDATE users SET username = :username, email = :email, password = :password WHERE id = :id';
        $params = [
            ':id' => $id,
            ':username' => $username,
            ':email' => $email,
            ':password' => $password,
        ];
        try {
            return $this->db_update($sql, $params);
        } catch (Throwable $error) {
            throw new Exception($error->getMessage());
        }
    }
    public function deleteUser(int $id)
    {
        $sql = 'DELETE FROM users WHERE id = :id';

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
    public function getUserByUsername($username)
    {
        $sql = 'SELECT * FROM users WHERE username = :username';

        $params = [
            ':username' => $username,
        ];
        try {
            return $this->db_read($sql, $params);
        } catch (Throwable $error) {
            throw new Exception($error->getMessage());
        }
    }
    public function getUserByEmail($email)
    {
        $sql = 'SELECT * FROM users WHERE email = :email';
        $params = [
            ':email' => $email,
        ];
        try {
            return $this->db_read($sql, $params);
        } catch (Throwable $error) {
            throw new Exception($error->getMessage());
        }
    }
}
