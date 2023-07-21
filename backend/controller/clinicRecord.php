<?php
class ClinicRecordController
{
    private $recordModel;

    public function __construct(RecordModel $recordModel)
    {
        $this->recordModel = $recordModel;
    }

    public function getAllRecords(): array
    {
        $records = $this->recordModel->getAllRecords();

        if (empty($records)) {
            return $this->errorResponse("No records found.");
        }

        return $this->successResponseWithData("Records successfully retrieved.", ['records' => $records]);
    }

    public function getRecordsByName(string $name): array
    {
        if (empty($name)) {
            return $this->errorResponse("Name parameter is required.");
        }

        $records = $this->recordModel->getRecordsByName($name);

        if (empty($records)) {
            return $this->errorResponse("No records found with the provided name.");
        }

        return $this->successResponseWithData("Records successfully retrieved by name.", ['records' => $records]);
    }

    public function getRecordById(int $id): array
    {
        if ($id <= 0) {
            return $this->errorResponse("Invalid ID parameter.");
        }

        $record = $this->recordModel->getRecordById($id);

        if (!$record) {
            return $this->errorResponse("Record not found.");
        }

        return $this->successResponseWithData("Record successfully retrieved.", ['record' => $record]);
    }

    private function successResponseWithData(string $message, array $data): array
    {
        return ['success' => true, 'message' => $message] + $data;
    }

    private function errorResponse(string $message): array
    {
        return ['success' => false, 'message' => $message];
    }
}
