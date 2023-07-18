<?php
require_once("../model/user.model.php");

//KUKUNIN NETO YUNG MGA PARAMETER FROM POST REQUEST YUNG MGA PINASA NI USER
if ($_POST['username']) {
    //LAGYAN KO DELAY PARA KUNWARE TOTOONG SERVER HAHA
    sleep(1);
    $username = $_POST['username'];
    $password = $_POST['password'];
    //checheck ko dito kung nainsert na tas maglalagay din ako validation dito
    if (setUserData($username, $password)) {
        //TAS IRE-RESPONSE YUNG DATA NA MAY isSuccess na bool tapos errorMessage na string
        //eto reresponse pag success
        $data = [
            "isSuccess" => true,
            "errorMessage" => ""
        ];
        echo json_encode($data);
        exit();
    }
}
//eto reresponse pag failed
$data = [
    "isSuccess" => false,
    "errorMessage" => "Username is already taken!"
];
echo json_encode($data);
