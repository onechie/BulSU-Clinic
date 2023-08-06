<?php
// Check if the file is being directly accessed via URL
require_once("../middleware/accessMiddleware.php");
Access::preventDirectAccess();
class UsersController
{
    private $userModel;

    public function __construct(UserModel $userModel)
    {
        $this->userModel = $userModel;
    }

    public function registerUser($req)
    {
        $expectedKeys = ['username', 'email', 'password', 'confirmPassword', 'agreement', 'X-CSRF-TOKEN'];
        $req = Data::filterData($req, $expectedKeys);
        try {
            $this->validateUserData($req);
            $this->isUsernameExists($req['username']);
            $this->isEmailExists($req['email']);
            if (filter_var($req['agreement'], FILTER_VALIDATE_BOOLEAN) === false) {
                return Response::errorResponse("You must agree to the terms and policies.");
            }
            $req['password'] = password_hash($req['password'], PASSWORD_DEFAULT);
            $result = $this->userModel->addUser(...array_values($req));
            if ($result) {
                return Response::successResponse($req['username'] . " registered successfully.");
            } else {
                return Response::errorResponse("User registration failed.");
            }
        } catch (Throwable $error) {
            return Response::errorResponse($error->getMessage());
        }
    }
    public function loginUser($req)
    {
        $expectedKeys = ['usernameOrEmail', 'password', 'keepLoggedIn', 'X-CSRF-TOKEN'];
        $req = Data::filterData($req, $expectedKeys);
        try {
            Data::onlyAlphaNum("Username or email", $req['usernameOrEmail'] ?? null);
            if (!isset($req['password'])) {
                return Response::errorResponse("Password is empty.");
            }
            $user = $this->userModel->getUserByEmail($req['usernameOrEmail']);
            if (!$user) {
                $user = $this->userModel->getUserByUsername($req['usernameOrEmail']);
            }
            if (!$user) {
                return Response::errorResponse("Invalid Credentials.");
            }
            if (password_verify($req['password'], $user['password'])) {
                if (filter_var($req['keepLoggedIn'], FILTER_VALIDATE_BOOLEAN)) {
                    // SET REFRESH TOKEN
                    $refresh_token = Auth::encodeRefreshJWT($user['id'], $user['username'], $user['email']);
                }
                // SET ACCESS TOKEN
                $access_token = Auth::encodeAccessJWT($user['id'], $user['username']);
                return Response::successResponse("User logged in successfully.");
            }
            return Response::errorResponse("Invalid Credentials.");
        } catch (Throwable $error) {
            return Response::errorResponse($error->getMessage());
        }
    }
    public function authenticateUser($req)
    {
        try {
            $refresh_token = $_COOKIE['r_jwt'] ?? '';
            $access_token = $_COOKIE['a_jwt'] ?? '';
            if ($refresh_token !== '') {
                $refreshJWTData = Auth::validateRefreshJWT($refresh_token);
                if ($refreshJWTData->type === "REFRESH") {
                    $access_token = Auth::encodeAccessJWT($refreshJWTData->sub, $refreshJWTData->username);
                    return Response::successResponse("Refresh token found.");
                }else{
                    return Response::errorResponse("Refresh token is invalid.");
                }
            } else {
                if ($access_token !== '') {
                    $accessJWTData = Auth::validateAccessJWT($access_token);
                    if ($accessJWTData->type === "ACCESS") {
                        return Response::successResponse("Access token found.");
                    } else {
                        return Response::errorResponse("Access token is invalid.");
                    }
                } else {
                    return Response::errorResponse("Access token not found.");
                }
            }
            // $allHeaders = getallheaders();
            // $authorizationHeader = $allHeaders['Authorization'] ?? '';
            // if (strpos($authorizationHeader, 'Bearer ') === 0) {
            //     $jwt = substr($authorizationHeader, 7);
            //     $user = Auth::decodeJWT($jwt);
            //     return Response::successResponseWithData("User authenticated successfully.", ['user' => $user]);
            // } else {
            //     return Response::errorResponse("User authentication failed.");
            // }
        } catch (Throwable $error) {
            return Response::errorResponse($error->getMessage());
        }
    }
    private function validateUserData($userData)
    {
        $username = $userData['username'] ?? '';
        $email = $userData['email'] ?? '';
        $password = $userData['password'] ?? '';
        $confirmPassword = $userData['confirmPassword'] ?? '';

        Data::onlyAlphaNum("Username", $username, false, false);
        if (strlen($username)  < 4 || strlen($username) > 20) {
            throw new Exception("Username must be 4 to 20 characters long.");
        }
        Data::onlyAlphaNum("Email", $email);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email format.");
        }
        if ($password === '' || $password === null) {
            throw new Exception("Password is empty.");
        }
        if (strlen($password) < 8) {
            throw new Exception("Password must be at least 8 characters long.");
        }
        if ($confirmPassword === '' || $confirmPassword === null) {
            throw new Exception("Confirm Password is empty.");
        }
        if ($password !== $confirmPassword) {
            throw new Exception("Password does not match.");
        }
    }
    private function isUsernameExists($username)
    {
        $user = $this->userModel->getUserByUsername($username);
        if ($user) {
            throw new Exception("Username already exists.");
        }
    }
    private function isEmailExists($email)
    {
        $user = $this->userModel->getUserByEmail($email);
        if ($user) {
            throw new Exception("Email already exists.");
        }
    }
}
