<?php class UserTableInitializer extends DatabaseInitializer
{
    public function __construct()
    {
        $tableName = 'users';
        $columns = [
            'username VARCHAR(255) NOT NULL',
            'email VARCHAR(255) NOT NULL',
            'password VARCHAR(255) NOT NULL',
            // Add more columns specific to the UserModel if needed
        ];

        parent::__construct($tableName, $columns);
    }
}

class UserModel extends UserTableInitializer
{
    public function __construct()
    {
        parent::__construct();
    }

    public function createUserRecord($username, $email, $hashedPassword): bool
    {
        $sql = 'INSERT INTO users (username, email, password) VALUES (:username, :email, :hashedPassword)';

        $pdo = $this->connect();

        try {
            $stmt = $pdo->prepare($sql);

            $params = [
                ':username' => $username,
                ':email' => $email,
                ':hashedPassword' => $hashedPassword,
            ];

            return $stmt->execute($params);
        } catch (PDOException $error) {
            throw new Exception('Database error: ' . $error->getMessage());
        }
    }

    public function findUserByUsernameOrEmail($username, $email)
    {
        $sql = 'SELECT * FROM users WHERE username = :username OR email = :email';

        $pdo = $this->connect();

        try {
            $stmt = $pdo->prepare($sql);

            $params = [
                ':username' => $username,
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
