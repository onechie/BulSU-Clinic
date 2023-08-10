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

        $pdo = $this->connect();

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $attachments = $stmt->fetchAll();
            return $attachments;
        } catch (PDOException $error) {
            throw new Exception('Database error: ' . $error->getMessage());
        }
    }
    public function getAttachment(int $id)
    {
        $sql = 'SELECT * FROM attachments WHERE id = :id';

        $pdo = $this->connect();

        try {
            $stmt = $pdo->prepare($sql);
            $params = [':id' => $id];
            $stmt->execute($params);
            $attachment = $stmt->fetch();
            return $attachment;
        } catch (PDOException $error) {
            throw new Exception('Database error: ' . $error->getMessage());
        }
    }
    public function addAttachment(int $recordId, string $name, string $url)
    {
        $sql = 'INSERT INTO attachments (recordId, name, url) VALUES (:recordId, :name, :url)';

        $pdo = $this->connect();

        try {
            $stmt = $pdo->prepare($sql);
            $params = [
                ':recordId' => $recordId,
                ':name' => $name,
                ':url' => $url,
            ];

            if ($stmt->execute($params)) {
                return true;
            } else {
                throw new Exception('Error while adding the attachment.');
            }
        } catch (PDOException $error) {
            throw new Exception('Database error: ' . $error->getMessage());
        }
    }
    public function updateAttachment(int $id, int $recordId, string $name, string $url)
    {
        $sql = 'UPDATE attachments SET recordId = :recordId, name = :name, url = :url WHERE id = :id';

        $pdo = $this->connect();

        try {
            $stmt = $pdo->prepare($sql);
            $params = [
                ':id' => $id,
                ':recordId' => $recordId,
                ':name' => $name,
                ':url' => $url,
            ];

            if ($stmt->execute($params)) {
                return true;
            } else {
                throw new Exception('Error while updating the attachment.');
            }
        } catch (PDOException $error) {
            throw new Exception('Database error: ' . $error->getMessage());
        }
    }

    public function deleteAttachment(int $id)
    {
        $sql = 'DELETE FROM attachments WHERE id = :id';

        $pdo = $this->connect();

        try {
            $stmt = $pdo->prepare($sql);
            $params = [':id' => $id];

            if ($stmt->execute($params)) {
                return true;
            } else {
                throw new Exception('Error while deleting the attachment.');
            }
        } catch (PDOException $error) {
            throw new Exception('Database error: ' . $error->getMessage());
        }
    }

    // CUSTOM METHODS
    public function getAttachmentByRecordId(int $recordId)
    {
        $sql = 'SELECT * FROM attachments WHERE recordId = :recordId';

        $pdo = $this->connect();

        try {
            $stmt = $pdo->prepare($sql);
            $params = [':recordId' => $recordId];
            $stmt->execute($params);
            $attachment = $stmt->fetchAll();
            return $attachment;
        } catch (PDOException $error) {
            throw new Exception('Database error: ' . $error->getMessage());
        }
    }
    public function deleteAttachmentByRecordId(int $recordId)
    {
        $sql = 'DELETE FROM attachments WHERE recordId = :recordId';

        $pdo = $this->connect();

        try {
            $stmt = $pdo->prepare($sql);
            $params = [':recordId' => $recordId];

            if ($stmt->execute($params)) {
                return true;
            } else {
                throw new Exception('Error while deleting the attachment.');
            }
        } catch (PDOException $error) {
            throw new Exception('Database error: ' . $error->getMessage());
        }
    }

}
