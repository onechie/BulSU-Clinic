<?php
// Check if the file is being directly accessed via URL
require_once("../utils/utility.php");
Utility::preventDirectAccess();

class StoragesController extends Utility
{
    private $storageModel;
    public function __construct(StorageModel $storageModel)
    {
        $this->storageModel = $storageModel;
    }
    public function getStorages()
    {
        try {
            //TRY TO GET ALL STORAGES
            $storages = $this->storageModel->getStorages();
            return $storages ? $this->successResponseWithData("Storages successfully fetched.", ['storages' => $storages]) : $this->errorResponse("No storages found.");
        } catch (Throwable $error) {
            return $this->errorResponse($error->getMessage());
        }
    }
    public function getStorage($req)
    {
        $expectedKeys = ['id'];
        $req = $this->filterData($req, $expectedKeys);
        try {
            $this->onlyNum("ID", $req['id'] ?? null);

            //TRY TO GET STORAGE BY ID
            $storage = $this->getStorageIfExists($req['id']);
            return $this->successResponseWithData("Storage successfully fetched.", ['storage' => $storage]);
        } catch (Throwable $error) {
            return $this->errorResponse($error->getMessage());
        }
    }
    public function addStorage($req)
    {
        $expectedKeys = ['description'];
        $req = $this->filterData($req, $expectedKeys);
        try {
            $this->onlyAlphaNum("Description", $req['description'] ?? null);
            $this->isStorageDescriptionExists($req['description']);

            //TRY TO ADD STORAGE
            $storage = $this->storageModel->addStorage($req['description']);
            return $storage ? $this->successResponse("Storage successfully added.") : $this->errorResponse("Storage failed to add.");
        } catch (Throwable $error) {
            return $this->errorResponse($error->getMessage());
        }
    }
    public function updateStorage($req)
    {
        $expectedKeys = ['id', 'description'];
        $req = $this->filterData($req, $expectedKeys);
        try {
            $this->onlyNum("ID", $req['id'] ?? null);
            $oldStorage = $this->getStorageIfExists($req['id']);
            
            $newData = $this->mergeData($oldStorage, $req);
            $this->onlyAlphaNum("Description", $newData['description']);

            //TRY TO UPDATE STORAGE
            $result = $this->storageModel->updateStorage(...array_values($newData));
            return $result ? $this->successResponse("Storage successfully updated.") : $this->errorResponse("Storage failed to update.");
        } catch (Throwable $error) {
            return $this->errorResponse($error->getMessage());
        }
    }
    public function deleteStorage($req)
    {
        $expectedKeys = ['id'];
        $req = $this->filterData($req, $expectedKeys);
        try {
            $this->onlyNum("ID", $req['id'] ?? null);
            $this->getStorageIfExists($req['id']);

            //TRY TO DELETE STORAGE
            $result = $this->storageModel->deleteStorage($req['id']);
            return $result ? $this->successResponse("Storage successfully deleted.") : $this->errorResponse("Storage failed to delete.");
        } catch (Throwable $error) {
            return $this->errorResponse($error->getMessage());
        }
    }
    private function isStorageDescriptionExists($description)
    {
        $storage = $this->storageModel->getStorageByDescription($description);
        if ($storage) throw new Exception("Storage already exists.");
    }
    private function getStorageIfExists($id)
    {
        $storage = $this->storageModel->getStorage($id);
        if (!$storage) throw new Exception("Storage does not exist.");
        return $storage;
    }
}