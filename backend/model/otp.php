<?php

class OtpModel extends Database
{
    public function __construct()
    {
        parent::__construct();
    }
    public function addOtp(string $code, string $email, string $expiresAt)
    {
        $sql = 'INSERT INTO otps (code, email, expiresAt) VALUES (:code, :email, :expiresAt)';
        $params = [
            ':code' => $code,
            ':email' => $email,
            ':expiresAt' => $expiresAt,
        ];
        try {
            return $this->db_create($sql, $params, true);
        } catch (Throwable $error) {
            throw new Exception($error->getMessage());
        }
    }
    // CUSTOM METHODS
    public function getOtpByCode(string $code)
    {
        $sql = 'SELECT * FROM otps WHERE code = :code';
        $params = [
            ':code' => $code,
        ];
        try {
            return $this->db_read($sql, $params);
        } catch (Throwable $error) {
            throw new Exception($error->getMessage());
        }
    }
    public function getOtpByEmail(string $email)
    {
        $sql = 'SELECT * FROM otps WHERE email = :email';
        $params = [
            ':email' => $email,
        ];
        try {
            return $this->db_read_all($sql, $params);
        } catch (Throwable $error) {
            throw new Exception($error->getMessage());
        }
    }
}
