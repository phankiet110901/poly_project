<?php

// tat ca function cua core se duoc dinh nghia o day

function Show404Err()
{
    echo "Loi: 404 (Khong tim thay trang)  !!!!!";
    die();
}

function ShowErr()
{

}

function ShowAlert($mess)
{
    echo "<script> alert('" . $mess . "')</script>";
}

function Redirect($link)
{
    header("location: http://localhost/MyPhpFramework/" . $link);
}

function GetLinkToRedirect($link)
{
    return "http://localhost/MyPhpFramework/" . $link;
}

function ShowErrNotFoundModel()
{

}

function SetDefaultPage($namePage, $defaulAction, $defaulParam)
{
    if ($namePage == "") {
        echo "Welcome to my php framework !!!";
    } else {
        new App($namePage, $defaulAction, $defaulParam);
    }
}

function GetAllGlobalData()
{
    global $globalData;
    return $globalData;
}

function GetGlobalData($dataName)
{
    global $globalData;
    return $globalData[$dataName];
}

function CheckAuthor($key, $page)
{
    if (isset($_SESSION[$key]) === false || empty($_SESSION[$key])) {
        Redirect($page);
    }
}

function OptionalChaining($arrayCheck, $key, $dataGet)
{
    if (isset($arrayCheck[$key]) === false || empty($arrayCheck) === true || isset($arrayCheck[$key][$dataGet]) === false) return "";
    return $arrayCheck[$key][$dataGet];
}

function genUUIDV4()
{
    return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',

        // 32 bits for "time_low"
        mt_rand(0, 0xffff), mt_rand(0, 0xffff),

        // 16 bits for "time_mid"
        mt_rand(0, 0xffff),

        // 16 bits for "time_hi_and_version",
        // four most significant bits holds version number 4
        mt_rand(0, 0x0fff) | 0x4000,

        // 16 bits, 8 bits for "clk_seq_hi_res",
        // 8 bits for "clk_seq_low",
        // two most significant bits holds zero and one for variant DCE1.1
        mt_rand(0, 0x3fff) | 0x8000,

        // 48 bits for "node"
        mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
    );
}