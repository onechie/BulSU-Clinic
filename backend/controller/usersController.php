<?php
class UsersController
{
    private $userModel;

    public function __construct(UserModel $userModel)
    {
        $this->userModel = $userModel;
    }
    public function getUser()
    {
        try {
            if (isset($_COOKIE['a_jwt'])) {
                $userData = Auth::validateAccessJWT($_COOKIE['a_jwt']);
                $userData = $this->userModel->getUser($userData->sub);
                $userData = Data::filterData($userData, ['username', 'email']);
                return Response::successResponseWithData("User data found.", ["user" => $userData]);
            } else {
                return Response::errorResponse("Access token not found.");
            }
        } catch (Throwable $error) {
            return Response::errorResponse($error->getMessage());
        }
    }
    public function changePassword($req)
    {
        $expectedKeys = ['oldPassword', 'password', 'confirmPassword', 'X-CSRF-TOKEN'];
        $req = Data::filterData($req, $expectedKeys);
        try {
            if (isset($_COOKIE['a_jwt'])) {
                $userData = Auth::validateAccessJWT($_COOKIE['a_jwt']);
                $userData = $this->userModel->getUser($userData->sub);

                $req['username'] = $userData['username'];
                $req['email'] = $userData['email'];
                $req['id'] = $userData['id'];

                $this->validateUserData($req);
                if (!password_verify($req['oldPassword'], $userData['password'])) {
                    return Response::errorResponse("Old password is incorrect.");
                } else if ($req['oldPassword'] === $req['password']) {
                    return Response::errorResponse("New password must be different from old password.");
                } else {
                    $req = Data::filterData($req, ['id', 'username', 'email', 'password']);
                    $req['password'] = password_hash($req['password'], PASSWORD_DEFAULT);
                    $this->userModel->updateUser(...array_values($req));
                    return Response::successResponse("Password updated successfully.");
                }
            } else {
                return Response::errorResponse("Access token not found.");
            }
        } catch (Throwable $error) {
            return Response::errorResponse($error->getMessage());
        }
    }
    public function logoutUser()
    {
        try {
            if (isset($_COOKIE['a_jwt'])) {
                $userData = Auth::validateAccessJWT($_COOKIE['a_jwt']);
                setcookie('a_jwt', '', time() - 3600, '/');
                setcookie('r_jwt', '', time() - 3600, '/');
                return Response::successResponse("User logged out successfully.");
            } else {
                return Response::errorResponse("Access token not found.");
            }
        } catch (Throwable $error) {
            return Response::errorResponse($error->getMessage());
        }
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
    public function authenticateUser()
    {
        try {
            $refresh_token = $_COOKIE['r_jwt'] ?? '';
            $access_token = $_COOKIE['a_jwt'] ?? '';
            if ($refresh_token !== '') {
                $refreshJWTData = Auth::validateRefreshJWT($refresh_token);
                if ($refreshJWTData->type === "REFRESH") {
                    $access_token = Auth::encodeAccessJWT($refreshJWTData->sub, $refreshJWTData->username);
                    return Response::successResponse("Refresh token found.");
                } else {
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
