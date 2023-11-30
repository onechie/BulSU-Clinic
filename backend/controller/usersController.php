<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

class UsersController
{
    private $userModel;
    private $profileModel;
    private $otpModel;
    public function __construct(UserModel $userModel, ProfileModel $profileModel, OtpModel $otpModel)
    {
        $this->userModel = $userModel;
        $this->profileModel = $profileModel;
        $this->otpModel = $otpModel;
    }
    public function getUser()
    {
        try {
            if (isset($_COOKIE['a_jwt'])) {
                $userData = Auth::validateAccessJWT($_COOKIE['a_jwt']);
                $userProfile = $this->profileModel->getProfileByUserId($userData->sub);
                $userData = $this->userModel->getUser($userData->sub);
                $userData = Data::filterData($userData, ['username', 'email']);

                if ($userProfile) {
                    $userData['profilePicture'] = $userProfile['url'];
                } else {
                    $userData['profilePicture'] = "";
                }
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
                    return Response::errorResponse("Current password is incorrect.");
                } else if ($req['oldPassword'] === $req['password']) {
                    return Response::errorResponse("New password must be different from current password.");
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

    public function registerUser($req, $file)
    {
        $expectedKeys = ['username', 'email', 'password', 'confirmPassword', 'otp', 'agreement', 'X-CSRF-TOKEN'];
        $req = Data::filterData($req, $expectedKeys);
        $formattedPicture = [];
        try {
            $this->validateUserData($req);
            if (File::hasPicture($file)) {
                $formattedPicture = File::formatPicture($file['profilePicture']);
                File::validatePicture($formattedPicture);
            }
            $this->isUsernameExists($req['username']);
            $this->isEmailExists($req['email']);
            if (!isset($req['agreement'])) {
                return Response::errorResponse("You must agree to the terms and policies.");
            }
            $req['password'] = password_hash($req['password'], PASSWORD_DEFAULT);
            $userId = $this->userModel->addUser(...array_values($req));
            if ($userId && File::hasPicture($file)) {
                $uploadedPicture = File::uploadPicture($formattedPicture, $userId);
                $this->profileModel->addProfile($userId, $uploadedPicture['name'], $uploadedPicture['url']);
            }
            return $userId ? Response::successResponse($req['username'] . " registered successfully") : Response::errorResponse("Registration failed.");
        } catch (Throwable $error) {
            return Response::errorResponse($error->getMessage());
        }
    }
    public function generateOTP($req)
    {
        $expectedKeys = ['email'];
        $req = Data::filterData($req, $expectedKeys);
        try {
            Data::onlyAlphaNum("Email", $req['email'] ?? null);
            if (!filter_var($req['email'], FILTER_VALIDATE_EMAIL)) {
                throw new Exception("Invalid email format.");
            }
            $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $otp = '';
            $length = 6;
            for ($i = 0; $i < $length; $i++) {
                $otp .= $characters[rand(0, strlen($characters) - 1)];
            }
            $now = new DateTime();
            $now->modify('+2 hour');
            $otpInserted = $this->otpModel->addOtp($otp, $req['email'], $now->format('Y-m-d H:i:s'));
            if ($otpInserted) {
                $this->sendEmail($req['email'], $otp);
                return Response::successResponse('Please check your email.');
            }
            return Response::errorResponse('Error occurred while sending.');
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
        $otp = $userData['otp'] ?? '';

        Data::onlyAlphaNum("Username", $username, false, false);
        if (strlen($username) < 4 || strlen($username) > 20) {
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
        Data::onlyAlphaNum("OTP", $otp, false, false);
        $checkOtp = $this->otpModel->getOtpByCode($otp);
        if (!$checkOtp || $checkOtp['email'] != $email) {
            throw new Exception("Invalid OTP.");
        }
        if ($checkOtp['expiresAt'] < date('Y-m-d H:i:s')) {
            throw new Exception('OTP expired.');
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
    private function sendEmail($email, $code)
    {
        $dotenv = Dotenv::createImmutable(__DIR__, "/../../.env");
        $dotenv->load();

        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host = $_ENV['SMTP_HOST'];
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['SMTP_EMAIL'];
            $mail->Password = $_ENV['SMTP_PASSWORD'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = $_ENV['SMTP_PORT'];

            //Recipients
            $mail->setFrom($_ENV['SMTP_EMAIL'], 'BulSU Health Services');
            $mail->addAddress($email);

            //Content
            $mail->isHTML(true);
            $mail->Subject = 'Account Verification';
            $mail->Body = "Your One-time password will expire in 2 hours.<br><br>$code<br><br>Thank you for registering to BulSU Health Services.";
            $mail->AltBody = '';

            $mail->send();
            return true;
        } catch (Exception $e) {
            // throw new Exception("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
            throw new Exception("Failed to send verification email.");
        }
    }
}
