<?php

class StoragesController
{
    private $storageModel;
    private $logModel;
    public function __construct(StorageModel $storageModel, LogModel $logModel)
    {
        $this->storageModel = $storageModel;
        $this->logModel = $logModel;
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
            $this->generateLog($storage, "Add Storage template", "A new storage template added \"" . $req['description'] . "\". Storage ID = " . $storage);
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
            $this->isStorageDescriptionExists($req['description']);
            //TRY TO UPDATE STORAGE
            $result = $this->storageModel->updateStorage(...array_values($newData));
            $this->generateLog($result, "Update Storage template", "Storage template \"" . $oldStorage['description'] . "\" updated to \"" . $req['description'] . "\". Storage ID = " . $req['id']);
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
            $storage = $this->getStorageIfExists($req['id']);

            //TRY TO DELETE STORAGE
            $result = $this->storageModel->deleteStorage($req['id']);
            $this->generateLog($result, "Delete Storage template", "Storage template \"" . $storage["description"] . "\" deleted. Storage ID = " . $req['id']);
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
    private function generateLog($condition, $action, $description)
    {
        if (!$condition) return;
        $access_token = $_COOKIE['a_jwt'] ?? '';
        $accessJWTData = Auth::validateAccessJWT($access_token);

        $userId = $accessJWTData->sub;
        $username = $accessJWTData->username;
        $this->logModel->addLog($userId, $username, $action, $description);
    }
}
