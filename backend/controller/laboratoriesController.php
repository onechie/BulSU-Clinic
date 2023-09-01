<?php

class LaboratoriesController
{
    private $laboratoryModel;
    private $logModel;
    public function __construct(LaboratoryModel $laboratoryModel, LogModel $logModel)
    {
        $this->laboratoryModel = $laboratoryModel;
        $this->logModel = $logModel;
    }
    public function getLaboratories()
    {
        try {
            //TRY TO GET ALL LABORATORIES
            $laboratories = $this->laboratoryModel->getLaboratories();
            return $laboratories ? Response::successResponseWithData("Laboratories successfully fetched.", ['laboratories' => $laboratories]) : Response::errorResponse("No laboratories found.");
        } catch (Throwable $error) {
            return Response::errorResponse($error->getMessage());
        }
    }
    public function getLaboratory($req)
    {
        $expectedKeys = ['id'];
        $req = Data::filterData($req, $expectedKeys);
        try {
            Data::onlyNum("ID", $req['id'] ?? null);

            //TRY TO GET LABORATORY BY ID
            $laboratory = $this->getLaboratoryIfExists($req['id']);
            return Response::successResponseWithData("Laboratory successfully fetched.", ['laboratory' => $laboratory]);
        } catch (Throwable $error) {
            return Response::errorResponse($error->getMessage());
        }
    }
    public function addLaboratory($req)
    {
        $expectedKeys = ['description'];
        $req = Data::filterData($req, $expectedKeys);
        try {
            Data::onlyAlphaNum("Description", $req['description'] ?? null);
            $this->isLaboratoryDescriptionExists($req['description']);

            //TRY TO ADD LABORATORY
            $result = $this->laboratoryModel->addLaboratory(...array_values($req));
            $this->generateLog($result, "Add Laboratory template", "A new laboratory template added \"" . $req['description'] . "\". Laboratory ID = " . $result);
            return $result ? Response::successResponse("Laboratory successfully added.") : Response::errorResponse("Laboratory failed to add.");
        } catch (Throwable $error) {
            return Response::errorResponse($error->getMessage());
        }
    }
    public function updateLaboratory($req)
    {
        $expectedKeys = ['id', 'description'];
        $req = Data::filterData($req, $expectedKeys);
        try {
            Data::onlyNum("ID", $req['id'] ?? null);
            $oldLaboratory = $this->getLaboratoryIfExists($req['id']);

            $newData = Data::mergeData($oldLaboratory, $req);
            Data::onlyAlphaNum("Description", $newData['description']);
            $this->isLaboratoryDescriptionExists($req['description']);
            //TRY TO UPDATE LABORATORY
            $result = $this->laboratoryModel->updateLaboratory(...array_values($newData));
            $this->generateLog($result, "Update Laboratory template", "Laboratory template \"" . $oldLaboratory['description'] . "\" updated to \"" . $req['description'] . "\". Laboratory ID = " . $req['id']);
            return $result ? Response::successResponse("Laboratory successfully updated.") : Response::errorResponse("Laboratory failed to update.");
        } catch (Throwable $error) {
            return Response::errorResponse($error->getMessage());
        }
    }
    public function deleteLaboratory($req)
    {
        $expectedKeys = ['id'];
        $req = Data::filterData($req, $expectedKeys);
        try {
            Data::onlyNum("ID", $req['id'] ?? null);
            $laboratory = $this->getLaboratoryIfExists($req['id']);

            //TRY TO DELETE LABORATORY
            $result = $this->laboratoryModel->deleteLaboratory($req['id']);
            $this->generateLog($result, "Delete Laboratory template", "Laboratory template \"" . $laboratory['description'] . "\" deleted. Laboratory ID = " . $req['id']);
            return $result ? Response::successResponse("Laboratory successfully deleted.") : Response::errorResponse("Laboratory failed to delete.");
        } catch (Throwable $error) {
            return Response::errorResponse($error->getMessage());
        }
    }
    private function isLaboratoryDescriptionExists($description)
    {
        $laboratory = $this->laboratoryModel->getLaboratoryByDescription($description);
        if ($laboratory) throw new Exception("Laboratory already exists.");
    }
    private function getLaboratoryIfExists($id)
    {
        $laboratory = $this->laboratoryModel->getLaboratory($id);
        if (!$laboratory) throw new Exception("Laboratory does not exist.");
        return $laboratory;
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
