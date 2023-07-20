<?php
class AttachmentModel extends Database
{
    public function __construct()
    {
        parent::__construct('attachments'); // Pass the table name as a string here
        $this->checkAndCreateTable();
    }
    protected function createTable(PDO $pdo)
    {
        // Define the SQL query to create the "attachments" table
        $sql = "
    CREATE TABLE IF NOT EXISTS attachments (
        id INT AUTO_INCREMENT PRIMARY KEY,
        record_id INT NOT NULL,
        attachment_name VARCHAR(255) NOT NULL,
        attachment_url VARCHAR(255) NOT NULL,
        created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (record_id) REFERENCES records(id) ON DELETE CASCADE
    )
    ";

        // Execute the SQL query to create the table 
        try {
            $pdo->exec($sql);
        } catch (PDOException $error) {
            // Handle any exceptions that occur during table creation
            throw new Exception('Database connection error: ' . $error->getMessage());
        }
    }

    public function setAttachment($recordId, $attachmentName, $attachmentUrl)
    {
        // Prepare the SQL query with positional placeholders (?)
        $sql = 'INSERT INTO attachments (record_id, attachment_name, attachment_url) VALUES (?, ?, ?)';

        // Get the PDO connection from the parent class
        $pdo = $this->getPdo();

        try {
            // Prepare the statement
            $stmt = $pdo->prepare($sql);

            // Bind the values to the placeholders and execute the statement
            if (!$stmt->execute([$recordId, $attachmentName, $attachmentUrl])) {
                return false;
            } else {
                return true;
            }
        } catch (PDOException $error) {
            // Handle any exceptions that occur during the insertion
            return false;
        }
    }

    public function getAttachmentsByRecordId($recordId)
    {
        // Prepare the SQL query to retrieve attachments by record_id
        $sql = 'SELECT * FROM attachments WHERE record_id = ?';

        // Get the PDO connection from the parent class
        $pdo = $this->getPdo();

        try {
            // Prepare the statement
            $stmt = $pdo->prepare($sql);

            // Bind the value to the placeholder and execute the statement
            $stmt->execute([$recordId]);

            // Fetch all the attachment data as an associative array
            $attachments = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Return the array of attachments
            return $attachments;
        } catch (PDOException $error) {
            // Handle any exceptions that occur during the query
            return false;
        }
    }
}
