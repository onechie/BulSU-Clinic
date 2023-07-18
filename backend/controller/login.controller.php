<?php
require_once("../model/user.model.php");

//KUKUNIN NETO YUNG MGA PARAMETER FROM GET REQUEST 
$id = $_GET['id'];
//TAS IRE-RESPONSE YUNG DATA NI USER
echo json_encode(getUserData($id));