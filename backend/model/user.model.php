<?php
class UserModel extends Database
{
    public function __construct()
    {
        parent::__construct('users'); // Pass the table name as a string here
        $this->checkAndCreateTable();
    }
    protected function createTable(PDO $pdo)
    {
        // Define the SQL query to create the "users" table
        $sql = "
            CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL,
                password VARCHAR(255) NOT NULL,
                created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )
        ";

        // Execute the SQL query to create the table
        try {
            $pdo->exec($sql);
        } catch (PDOException $error) {
            // Handle any exceptions that occur during table creation
            return false;
        }
    }
    public function setUser($username, $email, $hashedPassword)
    {
        // Prepare the SQL query with positional placeholders (?)
        $sql = 'INSERT INTO users (username, email, password) VALUES (?, ?, ?)';

        // Get the PDO connection from the parent class
        $pdo = $this->getPdo();

        try {
            // Prepare the statement
            $stmt = $pdo->prepare($sql);

            // Bind the values to the placeholders and execute the statement
            if (!$stmt->execute([$username, $email, $hashedPassword])) {
                return false;
            } else {
                return true;
            }
        } catch (PDOException $error) {
            // Handle any exceptions that occur during the insertion
            return false;
        }
    }
    public function getUser($username, $email)
    {
        // Prepare the SQL query to retrieve the user by username or email
        $sql = 'SELECT * FROM users WHERE username = ? OR email = ?';

        // Get the PDO connection from the parent class
        $pdo = $this->getPdo();

        try {
            // Prepare the statement
            $stmt = $pdo->prepare($sql);

            // Bind the values to the placeholders and execute the statement
            if (!$stmt->execute([$username, $email])) {
                return false;
            } else {
                // Fetch the user data
                $user = $stmt->fetch();

                // Return the user data (if found) or null (if not found)
                return $user !== false ? $user : null;
            }
        } catch (PDOException $error) {
            // Handle any exceptions that occur during the query
            return false;
        }
    }
}
