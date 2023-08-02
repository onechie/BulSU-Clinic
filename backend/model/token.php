<?php
// Check if the file is being directly accessed via URL
require_once("../utils/utility.php");
Utility::preventDirectAccess();
class TokenTableInitializer extends DatabaseInitializer
{
    public function __construct()
    {
        $tableName = 'tokens';
        $columns = [
            'refreshToken VARCHAR(255) NOT NULL',
            'userId INT NOT NULL',
            'expiration DATE NOT NULL',
            'FOREIGN KEY (userId) REFERENCES users(id) ON DELETE CASCADE'
        ];

        parent::__construct($tableName, $columns);
    }
}

class TokenModel extends TokenTableInitializer
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getTokens()
    {
        $sql = 'SELECT * FROM tokens';
        $pdo = $this->connect();
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $tokens = $stmt->fetchAll();
            return $tokens;
        } catch (PDOException $error) {
            throw new Exception('Database error: ' . $error->getMessage());
        }
    }
    public function getToken(int $id){
        $sql = 'SELECT * FROM tokens WHERE id = :id';
        $pdo = $this->connect();
        try {
            $stmt = $pdo->prepare($sql);
            $params = [
                ':id' => $id,
            ];
            $stmt->execute($params);
            $token = $stmt->fetch();
            return $token;
        } catch (PDOException $error) {
            throw new Exception('Database error: ' . $error->getMessage());
        }
    }
    public function addToken(string $refreshToken, int $userId, string $expiration)
    {
        $sql = 'INSERT INTO tokens (refreshToken, userId, expiration) VALUES (:refreshToken, :userId, :expiration)';
        $pdo = $this->connect();
        try {
            $stmt = $pdo->prepare($sql);
            $params = [
                ':refreshToken' => $refreshToken,
                ':userId' => $userId,
                ':expiration' => $expiration,
            ];
            if ($stmt->execute($params)) {
                return true;
            } else {
                throw new Exception('Error while adding the token.');
            }
        } catch (PDOException $error) {
            throw new Exception('Database error: ' . $error->getMessage());
        }
    }
    public function updateToken(int $id, string $refreshToken, string $expiration){
        $sql = 'UPDATE tokens SET refreshToken = :refreshToken, expiration = :expiration WHERE id = :id';
        $pdo = $this->connect();
        try {
            $stmt = $pdo->prepare($sql);
            $params = [
                ':id' => $id,
                ':refreshToken' => $refreshToken,
                ':expiration' => $expiration,
            ];
            if ($stmt->execute($params)) {
                return true;
            } else {
                throw new Exception('Error while updating the token.');
            }
        } catch (PDOException $error) {
            throw new Exception('Database error: ' . $error->getMessage());
        }
    }
    public function deleteToken(int $id)
    {
        $sql = 'DELETE FROM tokens WHERE id = :id';
        $pdo = $this->connect();
        try {
            $stmt = $pdo->prepare($sql);
            $params = [
                ':id' => $id,
            ];
            if ($stmt->execute($params)) {
                return true;
            } else {
                throw new Exception('Error while deleting the token.');
            }
        } catch (PDOException $error) {
            throw new Exception('Database error: ' . $error->getMessage());
        }
    }

    //CUSTOM METHODS
    public function getTokenByRefreshToken(string $refreshToken){
        $sql = 'SELECT * FROM tokens WHERE refreshToken = :refreshToken';
        $pdo = $this->connect();
        try {
            $stmt = $pdo->prepare($sql);
            $params = [
                ':refreshToken' => $refreshToken,
            ];
            $stmt->execute($params);
            $token = $stmt->fetch();
            return $token;
        } catch (PDOException $error) {
            throw new Exception('Database error: ' . $error->getMessage());
        }
    }
}
