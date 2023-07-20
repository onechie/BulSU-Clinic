<?php
class ClinicRecordController
{
    private $recordModel;

    public function __construct(RecordModel $recordModel)
    {
        $this->recordModel = $recordModel;
    }

    public function getAllRecord()
    {
        // Call the getAllRecords method in the RecordModel to fetch all records from the database
        $records = $this->recordModel->getRecord();

        // Check if any records were found
        if (empty($records)) {
            return [
                'success' => false,
                'message' => "No records found."
            ];
        }

        // Return the records as a response
        return [
            'success' => true,
            'message' => "Records successfully retrieved.",
            'records' => $records
        ];
    }
    public function getAllRecordByName($name)
    {
        // Call the getRecordsByName method in the RecordModel to fetch records with the provided name
        $records = $this->recordModel->getRecordsByName($name);

        // Check if any records were found
        if (empty($records)) {
            return [
                'success' => false,
                'message' => "No records found with the provided name."
            ];
        }

        // Return the records as a response
        return [
            'success' => true,
            'message' => "Records successfully retrieved by name.",
            'records' => $records
        ];
    }
    public function getRecordById($id)
    {
        // Call the getRecordById method in the RecordModel to fetch a record by its ID
        $record = $this->recordModel->getRecordById($id);

        // Check if the record was found
        if (!$record) {
            return [
                'success' => false,
                'message' => "Record not found."
            ];
        }

        // Return the record as a response
        return [
            'success' => true,
            'message' => "Record successfully retrieved.",
            'record' => $record
        ];
    }
}
