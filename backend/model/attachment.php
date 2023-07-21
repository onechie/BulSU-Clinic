<?php
class AttachmentTableInitializer extends DatabaseInitializer
{
    public function __construct()
    {
        $tableName = 'attachments';
        $columns = [
            'record_id INT NOT NULL',
            'attachment_name VARCHAR(255) NOT NULL',
            'attachment_url VARCHAR(255) NOT NULL',
        ];

        parent::__construct($tableName, $columns);
    }
}

class AttachmentModel extends AttachmentTableInitializer
{
    public function __construct()
    {
        parent::__construct();
    }

    public function addAttachment($recordId, $attachmentName, $attachmentUrl)
    {
        $sql = 'INSERT INTO attachments (record_id, attachment_name, attachment_url) VALUES (:recordId, :attachmentName, :attachmentUrl)';

        $pdo = $this->connect();

        try {
            $stmt = $pdo->prepare($sql);
            $params = [
                ':recordId' => $recordId,
                ':attachmentName' => $attachmentName,
                ':attachmentUrl' => $attachmentUrl,
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

    public function getAttachmentsByRecordId($recordId)
    {
        $sql = 'SELECT * FROM attachments WHERE record_id = :recordId';

        $pdo = $this->connect();

        try {
            $stmt = $pdo->prepare($sql);
            $params = [':recordId' => $recordId];
            $stmt->execute($params);
            $attachments = $stmt->fetchAll();
            return $attachments;
        } catch (PDOException $error) {
            throw new Exception('Database error: ' . $error->getMessage());
        }
    }
}
