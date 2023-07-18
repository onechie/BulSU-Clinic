<?php
//SAMPLE DATA LANG TO WALA PANG DATABASE
function getUserData($id)
{
    //EXAMPLE ETO MGA DATA SA DATABASE
    $Users = [
        "1" => [
            "Name" => "SampleUser1",
            "Password" => "Password123"
        ],
        "2" => [
            "Name" => "SampleUser2",
            "Password" => "Password123"
        ], "3" => [
            "Name" => "SampleUser3",
            "Password" => "Password123"
        ]
    ];

    return $Users[strval($id)];
}

function setUserData($username, $password){
    //kunware iinsert ko dito sa database
    //then magrereturn true kase success
    return true;
}