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

    public function SelectAll(string $tableName): array
    {

        $sql = "SELECT * FROM `$tableName` ";
        $res = $this->conn->Query($sql);

        $dataOutput = [];

        while ($rows = $res->fetch_assoc()) {
            array_push($dataOutput, $rows);
        }

        return $dataOutput;
    }

    public function SelectAllCondition($tableName, $condition)
    {
        // Get Condition
        $keySql = "";
        $valueSql = "";

        foreach($condition as $key => $value)
        {
            $keySql = $key;
            $valueSql = $value;
        }

        $sql = "SELECT * FROM `$tableName` WHERE `$keySql` = '$valueSql'";
        $res = $this->conn->Query($sql) or die($this->conn->error);

        $dataOutput = [];

        while ($rows = $res->fetch_assoc()) {
            array_push($dataOutput, $rows);
        }
        return $dataOutput;
    }


    public function Delete(string $tableName, array $condition): bool
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

    public function Update(string $tableName, array $dataUpdate, array $condition): bool
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

    public function Insert(string $tableName, array $dataInsert): bool
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

    public function Select(string $tableName, array $fieldList): array
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

    public function CustomQuery(string $sql): bool
    {
        return $this->conn->Query($sql);
    }


    public function SearchQuery(string $sql): array
    {
        $result = $this->conn->Query($sql);

        $dataOutput = [];

        while ($rows = $result->fetch_assoc()) {
            array_push($dataOutput, $rows);
        }

        return $dataOutput;
    }

    public function SelectCondition(string $tableName, array $fieldList, array $condition): array
    {

        $fields = "";

        $listField = array_keys($condition);
        $listValue = array_values($condition);

        $conditionInQuery = "";

        if (count($condition) === 1) {
            $conditionInQuery = "${listField[0]} = '${listValue[0]}' ";
        } else {
            foreach ($condition as $field => $value) {
                $conditionInQuery .= "${field} = '${value}' AND ";
            }
            $conditionInQuery = rtrim($conditionInQuery, ' AND');
        }

        // lay tung field
        foreach ($fieldList as $value) {
            $fields .= "`$value`,";
        }
        $fields = substr($fields, 0, strlen($fields) - 1); // loai bo ki tu cuoi cung cua chuoi

        $sql = "SELECT $fields FROM $tableName Where ${conditionInQuery} ";

        $res = $this->conn->Query($sql);

        $dataOutput = [];

        while ($rows = $res->fetch_assoc()) {
            array_push($dataOutput, $rows);
        }

        return $dataOutput;
    }

    public function CountRow(string $tableName, array $dataCheck): int
    {
        $listField = array_keys($dataCheck);
        $listValue = array_values($dataCheck);

        foreach ($listField as $key => $value) {
            $listField[$key] = "`" . $value . "`";
        }

        $conditionInQuery = "";

        if (count($dataCheck) === 1) {
            $conditionInQuery = "${listField[0]} = '${listValue[0]}' ";
        } else {
            foreach ($dataCheck as $field => $value) {
                $conditionInQuery .= "${field} = '${value}' AND ";
            }
            $conditionInQuery = rtrim($conditionInQuery, ' AND');
        }

        $sql = "SELECT count(*) as total FROM ${tableName} WHERE ${conditionInQuery}";

        return $this->conn->Query($sql)->fetch_assoc()["total"];
    }

    public function CountWithoutCondition(string $tableName): int
    {
        $sql = "SELECT count(*) as total FROM ${tableName}";

        return $this->conn->Query($sql)->fetch_assoc()["total"];
    }

    public function SelectWithLimit(string $tableName, array $size) : array
    {
        // Get Condition
        $start = "";
        $end = "";
        
        foreach($size as $key => $value)
        {
            $start = $key;
            $end = $value;
        }
        
        $sql = "SELECT * FROM `$tableName` LIMIT $start, $end";
        $res = $this->conn->Query($sql);
        
        $dataOutput = [];
        
        while ($rows = $res->fetch_assoc()) {
            array_push($dataOutput, $rows);
        }
        return $dataOutput;        
    }

}
