<?php
// Check if the file is being directly accessed via URL
require_once("../middleware/accessMiddleware.php");
Access::preventDirectAccess();

class StoragesController
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
            return $storages ? Response::successResponseWithData("Storages successfully fetched.", ['storages' => $storages]) : Response::errorResponse("No storages found.");
        } catch (Throwable $error) {
            return Response::errorResponse($error->getMessage());
        }
    }
    public function getStorage($req)
    {
        $expectedKeys = ['id'];
        $req = Data::filterData($req, $expectedKeys);
        try {
            Data::onlyNum("ID", $req['id'] ?? null);

            //TRY TO GET STORAGE BY ID
            $storage = $this->getStorageIfExists($req['id']);
            return Response::successResponseWithData("Storage successfully fetched.", ['storage' => $storage]);
        } catch (Throwable $error) {
            return Response::errorResponse($error->getMessage());
        }
    }
    public function addStorage($req)
    {
        $expectedKeys = ['description'];
        $req = Data::filterData($req, $expectedKeys);
        try {
            Data::onlyAlphaNum("Description", $req['description'] ?? null);
            $this->isStorageDescriptionExists($req['description']);

            //TRY TO ADD STORAGE
            $storage = $this->storageModel->addStorage($req['description']);
            return $storage ? Response::successResponse("Storage successfully added.") : Response::errorResponse("Storage failed to add.");
        } catch (Throwable $error) {
            return Response::errorResponse($error->getMessage());
        }
    }
    public function updateStorage($req)
    {
        $expectedKeys = ['id', 'description'];
        $req = Data::filterData($req, $expectedKeys);
        try {
            Data::onlyNum("ID", $req['id'] ?? null);
            $oldStorage = $this->getStorageIfExists($req['id']);
            
            $newData = Data::mergeData($oldStorage, $req);
            Data::onlyAlphaNum("Description", $newData['description']);

            //TRY TO UPDATE STORAGE
            $result = $this->storageModel->updateStorage(...array_values($newData));
            return $result ? Response::successResponse("Storage successfully updated.") : Response::errorResponse("Storage failed to update.");
        } catch (Throwable $error) {
            return Response::errorResponse($error->getMessage());
        }
    }
    public function deleteStorage($req)
    {
        $expectedKeys = ['id'];
        $req = Data::filterData($req, $expectedKeys);
        try {
            Data::onlyNum("ID", $req['id'] ?? null);
            $this->getStorageIfExists($req['id']);

            //TRY TO DELETE STORAGE
            $result = $this->storageModel->deleteStorage($req['id']);
            return $result ? Response::successResponse("Storage successfully deleted.") : Response::errorResponse("Storage failed to delete.");
        } catch (Throwable $error) {
            return Response::errorResponse($error->getMessage());
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