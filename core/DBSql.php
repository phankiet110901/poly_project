<?php

class DBSql
{

    private $host = "localhost";
    private $userName = "root";
    private $pass = "";
    private $dbName = "project";
    protected $conn;

    public function __construct()
    {
        $this->conn = new mysqli($this->host, $this->userName, $this->pass, $this->dbName); // ket noi database
        mysqli_query($this->conn, "SET NAMES 'utf-8' ");
    }

    public function SelectAll($tableName)
    {

        $sql = "SELECT * FROM `$tableName` ";
        $res = $this->conn->Query($sql);

        $dataOutput = [];

        while ($rows = $res->fetch_assoc()) {
            array_push($dataOutput, $rows);
        }

        return $dataOutput;
    }

    public function Delete($tableName, $condition)
    {

        $keySql = "";
        $valueSql = "";

        foreach ($condition as $key => $value) {
            $keySql = $key;
            $valueSql = $value;
        }

        $sql = "DELETE FROM {$tableName} Where `$keySql` = '$valueSql'";

        $res = $this->conn->Query($sql);

        if ($res) {
            return true;
        }

        return false;
    }

    public function Update($tableName, $dataUpdate, $condition)
    {
        $keySql = "";
        $valueSql = "";

        // process field and value
        foreach ($condition as $key => $value) {
            $keySql = $key;
            $valueSql = $value;
        }

        // process update SET
        $updateSet = "";
        foreach ($dataUpdate as $field => $value) {
            $updateSet .= "`$field` = '$value',";
        }

        $updateSet = substr($updateSet, 0, strlen($updateSet) - 1);

        $sql = "UPDATE `$tableName` SET $updateSet WHERE `$keySql` = '$valueSql' ";

        if ($this->conn->Query($sql)) {
            return true;
        }

        return false;
    }

    public function Insert($tableName, $dataInsert)
    {

        $fields = "( ";
        $values = "( ";

        foreach ($dataInsert as $field => $value) {
            $fields .= "`$field`,";
            $values .= "'$value',";
        }


        $fields = substr($fields, 0, strlen($fields) - 1) . ")";
        $values = substr($values, 0, strlen($values) - 1) . ")";

        $sql = "INSERT INTO `$tableName` $fields VALUES $values ";
        if ($this->conn->Query($sql)) {
            return true;
        }

        return false;
    }

    public function Select($tableName, $fieldList)
    {

        $fields = "";

        // lay tung field 
        foreach ($fieldList as $value) {
            $fields .= "`$value`,";
        }
        $fields = substr($fields, 0, strlen($fields) - 1); // loai bo ki tu cuoi cung cua chuoi

        $sql = "SELECT $fields FROM $tableName";

        $res = $this->conn->Query($sql);

        $dataOutput = [];

        while ($rows = $res->fetch_assoc()) {
            array_push($dataOutput, $rows);
        }

        return $dataOutput;
    }

    public function CustomQuery($sql)
    {   
        return $this->conn->Query($sql);
    }

    public function SelectCondition($tableName, $fieldList, $condition)
    {

        $fields = "";

        $keySql = "";
        $valueSql = "";

        foreach ($condition as $key => $value) {
            $keySql = $key;
            $valueSql = $value;
        }

        // lay tung field 
        foreach ($fieldList as $value) {
            $fields .= "`$value`,";
        }
        $fields = substr($fields, 0, strlen($fields) - 1); // loai bo ki tu cuoi cung cua chuoi

        $sql = "SELECT $fields FROM $tableName Where `$keySql` = '$valueSql' ";

        $res = $this->conn->Query($sql);

        $dataOutput = [];

        while ($rows = $res->fetch_assoc()) {
            array_push($dataOutput, $rows);
        }

        return $dataOutput;
    }
}
