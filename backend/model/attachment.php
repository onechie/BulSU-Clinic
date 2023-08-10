<?php
class AttachmentModel extends Database
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAttachments()
    {
        $sql = 'SELECT * FROM attachments';
        try {
            return $this->db_read_all($sql);
        } catch (Throwable $error) {
            throw new Exception($error->getMessage());
        }
    }
    public function getAttachment(int $id)
    {
        $sql = 'SELECT * FROM attachments WHERE id = :id';
        $params = [':id' => $id];
        try {
            return $this->db_read($sql, $params);
        } catch (Throwable $error) {
            throw new Exception($error->getMessage());
        }
    }
    public function addAttachment(int $recordId, string $name, string $url)
    {
        $sql = 'INSERT INTO attachments (recordId, name, url) VALUES (:recordId, :name, :url)';
        $params = [
            ':recordId' => $recordId,
            ':name' => $name,
            ':url' => $url,
        ];
        try {
            return $this->db_create($sql, $params);
        } catch (Throwable $error) {
            throw new Exception($error->getMessage());
        }
    }
    public function updateAttachment(int $id, int $recordId, string $name, string $url)
    {
        $sql = 'UPDATE attachments SET recordId = :recordId, name = :name, url = :url WHERE id = :id';
        $params = [
            ':id' => $id,
            ':recordId' => $recordId,
            ':name' => $name,
            ':url' => $url,
        ];
        try {
            return $this->db_update($sql, $params);
        } catch (Throwable $error) {
            throw new Exception($error->getMessage());
        }
    }
    public function deleteAttachment(int $id)
    {
        $sql = 'DELETE FROM attachments WHERE id = :id';
        $params = [':id' => $id];
        try {
            return $this->db_delete($sql, $params);
        } catch (Throwable $error) {
            throw new Exception($error->getMessage());
        }
    }

    // CUSTOM METHODS
    public function getAttachmentByRecordId(int $recordId)
    {
        $sql = 'SELECT * FROM attachments WHERE recordId = :recordId';
        $params = [':recordId' => $recordId];
        try {
            $attachment = $this->db_read_all($sql, $params);
            return $attachment;
        } catch (Throwable $error) {
            throw new Exception($error->getMessage());
        }
    }
    public function deleteAttachmentByRecordId(int $recordId)
    {
        $sql = 'DELETE FROM attachments WHERE recordId = :recordId';
        $params = [':recordId' => $recordId];
        try {
            return $this->db_delete($sql, $params);
        } catch (Throwable $error) {
            throw new Exception($error->getMessage());
        }
    }
}
