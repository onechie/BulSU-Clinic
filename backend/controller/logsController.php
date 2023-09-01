<?php

class LogsController
{
    private $logModel;
    public function __construct(LogModel $logModel)
    {
        $this->logModel = $logModel;
    }
    public function getLogs()
    {
        try {
            //TRY TO GET ALL LOGS
            $logs = $this->logModel->getLogs();
            return $logs ? Response::successResponseWithData("Logs successfully fetched.", ['logs' => $logs]) : Response::errorResponse("No logs found.");
        } catch (Throwable $error) {
            return Response::errorResponse($error->getMessage());
        }
    }
    public function getLog($req)
    {
        $expectedKeys = ['id'];
        $req = Data::filterData($req, $expectedKeys);
        try {
            Data::onlyNum("ID", $req['id'] ?? null);

            //TRY TO GET LOG BY ID
            $laboratory = $this->logModel->getLog($req['id']);
            return Response::successResponseWithData("Laboratory successfully fetched.", ['laboratory' => $laboratory]);
        } catch (Throwable $error) {
            return Response::errorResponse($error->getMessage());
        }
    }
    public function addLog($req)
    {
        $expectedKeys = ['userId', 'username', 'description'];
        try {
            Data::onlyAlphaNum("Description", $req['description'] ?? null);
            $access_token = $_COOKIE['a_jwt'] ?? '';
            $accessJWTData = Auth::validateAccessJWT($access_token);
            if ($accessJWTData->type !== "ACCESS") {
                return Response::errorResponse("Access token is invalid.");
            }
            $req['userId'] = $accessJWTData->sub;
            $req['username'] = $accessJWTData->username;

            $req = Data::filterData($req, $expectedKeys);

            //TRY TO ADD LOG
            $result = $this->logModel->addLog(...array_values($req));
            return $result ? Response::successResponse("Log successfully added.") : Response::errorResponse("Log failed to add.");
        } catch (Throwable $error) {
            return Response::errorResponse($error->getMessage());
        }
    }
}
