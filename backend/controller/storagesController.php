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
            if (!$storages) {
                return $this->errorResponse("No storages found.");
            }
            return $this->successResponseWithData("Storages successfully fetched.", ['storages' => $storages]);
        } catch (Exception $error) {
            return $this->errorResponse($error->getMessage());
        }
    }
    public function getStorage($req)
    {
        $expectedKeys = ['id'];
        try {
            //REMOVE UNEXPECTED KEY VALUE PAIRS
            $req = array_intersect_key($req, array_flip($expectedKeys));

            //INPUT VALIDATION
            $this->onlyNum("ID", $req['id'] ?? null);

            //TRY TO GET STORAGE BY ID
            $storage = $this->storageModel->getStorage($req['id']);
            if (!$storage) {
                return $this->errorResponse("Storage does not exist.");
            }
            return $this->successResponseWithData("Storage successfully fetched.", ['storage' => $storage]);
        } catch (Exception $error) {
            return $this->errorResponse($error->getMessage());
        }
    }

    public function addStorage($req)
    {
        $expectedKeys = ['description'];
        try {
            //REMOVE UNEXPECTED KEY VALUE PAIRS
            $req = array_intersect_key($req, array_flip($expectedKeys));

            //INPUT VALIDATION
            $this->onlyAlphaNum("Description", $req['description'] ?? null);

            //CHECK IF STORAGE ALREADY EXISTS
            $this->storageDescriptionExists($req['description']);

            //TRY TO ADD STORAGE
            $storage = $this->storageModel->addStorage($req['description']);
            if (!$storage) {
                return $this->errorResponse("Failed to add storage.");
            }
            return $this->successResponse("Storage successfully added.");
        } catch (Exception $error) {
            return $this->errorResponse($error->getMessage());
        }
    }

    public function updateStorage($req)
    {
        $expectedKeys = ['id', 'description'];
        try {
            //REMOVE UNEXPECTED KEY VALUE PAIRS
            $req = array_intersect_key($req, array_flip($expectedKeys));

            //INPUT VALIDATION
            $this->onlyNum("ID", $req['id'] ?? null);

            //CHECK IF STORAGE EXISTS
            $oldStorage = $this->storageModel->getStorage($req['id']);
            if (!$oldStorage) {
                throw new Exception("Storage does not exist.");
            }

            //REMOVE EMPTY ARRAY VALUES TO PREPARE FOR MERGE
            $req = array_filter($req, function ($value) {
                return !empty($value);
            });

            //MERGE OLD STORAGE DATA WITH NEW STORAGE DATA ONLY
            $newStorageData = array_merge($oldStorage, $req);

            //CHECK IF THERE ARE ANY CHANGES
            $differences = array_diff_assoc($oldStorage, $newStorageData);
            if (empty($differences)) {
                return $this->errorResponse("No changes were made.");
            }

            //INPUT VALIDATION
            $this->onlyAlphaNum("Description", $newStorageData['description']);

            //TRY TO UPDATE STORAGE
            $result = $this->storageModel->updateStorage(...array_values($newStorageData));
            if (!$result) {
                return $this->errorResponse("Storage failed to update.");
            }
            return $this->successResponse("Storage successfully updated.");
        } catch (Exception $error) {
            return $this->errorResponse($error->getMessage());
        }
    }

    public function deleteStorage($req){
        $expectedKeys = ['id'];
        try {
            //REMOVE UNEXPECTED KEY VALUE PAIRS
            $req = array_intersect_key($req, array_flip($expectedKeys));

            //INPUT VALIDATION
            $this->onlyNum("ID", $req['id'] ?? null);

            //CHECK IF STORAGE EXISTS
            $storage = $this->storageModel->getStorage($req['id']);
            if (!$storage) {
                throw new Exception("Storage does not exist.");
            }

            //TRY TO DELETE STORAGE
            $result = $this->storageModel->deleteStorage($req['id']);
            if (!$result) {
                return $this->errorResponse("Storage failed to delete.");
            }
            return $this->successResponse("Storage successfully deleted.");
        } catch (Exception $error) {
            return $this->errorResponse($error->getMessage());
        }
    }

    private function storageDescriptionExists($description)
    {
        $storage = $this->storageModel->getStorageByDescription($description);
        if ($storage) {
            throw new Exception("Storage already exists.");
        }
    }
}
