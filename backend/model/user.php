<?php

class UserModel extends Database
{
    public function getUsers()
    {
        $sql = 'SELECT * FROM users';

        $pdo = $this->connect();

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $users = $stmt->fetchAll();

            return $users !== false ? $users : null;
        } catch (PDOException $error) {
            throw new Exception('Database error: ' . $error->getMessage());
        }
    }
    public function getUser(int $id)
    {
        $sql = 'SELECT * FROM users WHERE id = :id';

        $pdo = $this->connect();

        try {
            $stmt = $pdo->prepare($sql);

            $params = [
                ':id' => $id,
            ];

            $stmt->execute($params);
            $user = $stmt->fetch();

            return $user !== false ? $user : null;
        } catch (PDOException $error) {
            throw new Exception('Database error: ' . $error->getMessage());
        }
    }
    public function addUser(string $username, string $email, string $password)
    {
        $sql = 'INSERT INTO users (username, email, password) VALUES (:username, :email, :password)';

        $pdo = $this->connect();

        try {
            $stmt = $pdo->prepare($sql);

            $params = [
                ':username' => $username,
                ':email' => $email,
                ':password' => $password,
            ];

            return $stmt->execute($params);
        } catch (PDOException $error) {
            throw new Exception('Database error: ' . $error->getMessage());
        }
    }
    public function updateUser(int $id, string $username, string $email, string $password)
    {
        $sql = 'UPDATE users SET username = :username, email = :email, password = :password WHERE id = :id';

        $pdo = $this->connect();

        try {
            $stmt = $pdo->prepare($sql);

            $params = [
                ':id' => $id,
                ':username' => $username,
                ':email' => $email,
                ':password' => $password,
            ];

            return $stmt->execute($params);
        } catch (PDOException $error) {
            throw new Exception('Database error: ' . $error->getMessage());
        }
    }
    public function deleteUser(int $id)
    {
        $sql = 'DELETE FROM users WHERE id = :id';

        $pdo = $this->connect();

        try {
            $stmt = $pdo->prepare($sql);

            $params = [
                ':id' => $id,
            ];

            return $stmt->execute($params);
        } catch (PDOException $error) {
            throw new Exception('Database error: ' . $error->getMessage());
        }
    }
    // CUSTOM METHODS
    public function getUserByUsername($username)
    {
        $sql = 'SELECT * FROM users WHERE username = :username';

        $pdo = $this->connect();

        try {
            $stmt = $pdo->prepare($sql);

            $params = [
                ':username' => $username,
            ];

            $stmt->execute($params);
            $user = $stmt->fetch();

            return $user !== false ? $user : null;
        } catch (PDOException $error) {
            throw new Exception('Database error: ' . $error->getMessage());
        }
    }
    public function getUserByEmail($email)
    {
        $sql = 'SELECT * FROM users WHERE email = :email';

        $pdo = $this->connect();

        try {
            $stmt = $pdo->prepare($sql);

            $params = [
                ':email' => $email,
            ];

            $stmt->execute($params);
            $user = $stmt->fetch();

            return $user !== false ? $user : null;
        } catch (PDOException $error) {
            throw new Exception('Database error: ' . $error->getMessage());
        }
    }
}