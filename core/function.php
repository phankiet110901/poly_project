<?php 

// tat ca function cua core se duoc dinh nghia o day

function Show404Err(){
    echo "Loi: 404 (Khong tim thay trang)  !!!!!";
    die();
}
function ShowAlert($mess){
    echo "<script> alert('".$mess."')</script>";
}

function Redirect($link){
    header("location: http://localhost/poly_project/".$link);
}

function GetLinkToRedirect($link) {
    return "http://localhost/poly_project/".$link;
}

function ShowErrNotFoundModel(){
    
}

function SetDefaultPage($namePage,$defaulAction, $defaulParam){
    if($namePage == ""){
        echo "Welcome to my php framework !!!";
    }else{
        new App($namePage,$defaulAction,$defaulParam);
    }
}

function GetAllGlobalData(){
    global $globalData;
    return $globalData;
}

function GetGlobalData($dataName){
    global $globalData;
    return $globalData[$dataName];
}

function CheckAuthor($key, $page) {
    if(isset($_SESSION[$key]) === false || empty($_SESSION[$key]) ) {
        Redirect($page);
    }
}

function OptionalChaining($arrayCheck, $key, $dataGet) {
    if( isset($arrayCheck[$key]) === false || empty($arrayCheck) === true || isset($arrayCheck[$key][$dataGet]) === false ) return "";
    return $arrayCheck[$key][$dataGet];
}