<?php
class ProfileModel extends Database
{
    public function __construct()
    {
        parent::__construct();
    }
    public function addProfile(int $userId, string $name, string $url)
    {
        $sql = 'INSERT INTO profiles (userId, name, url) VALUES (:userId, :name, :url)';
        $params = [
            ':userId' => $userId,
            ':name' => $name,
            ':url' => $url,
        ];
        try {
            return $this->db_create($sql, $params);
        } catch (Throwable $error) {
            throw new Exception($error->getMessage());
        }
    }
    // CUSTOM METHODS
    public function getProfileByUserId(int $userId)
    {
        $sql = 'SELECT * FROM profiles WHERE userId = :userId';
        $params = [':userId' => $userId];
        try {
            $attachment = $this->db_read($sql, $params);
            return $attachment;
        } catch (Throwable $error) {
            throw new Exception($error->getMessage());
        }
    }
    public function deleteProfileByUserId(int $userId)
    {
        $sql = 'DELETE FROM profiles WHERE userId = :userId';
        $params = [':userId' => $userId];
        try {
            return $this->db_delete($sql, $params);
        } catch (Throwable $error) {
            throw new Exception($error->getMessage());
        }
    }
}
