<?php

abstract class Controller
{
    private $modelUrl = "./mvc/models/";
    private $viewUrl = "./mvc/views/";

    public function LoadModel($modelName)
    {
        // kiem tra model co ton tai hay khong
        if (file_exists($this->modelUrl . $modelName . ".php")) {
            require_once $this->modelUrl . $modelName . ".php";
            return new $modelName;
        }
    }

    public function LoadView($viewName, $data = [])
    {
        // kiem tra view co ton tai hay khong
        if (file_exists($this->viewUrl . $viewName . ".php")) {
            require_once $this->viewUrl . $viewName . ".php";
            //return new $viewName;
        }
    }

    abstract public function DefaultPage();

    protected function response($status_code, $data = [])
    {
        // Allow from any origin
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
            header('Access-Control-Allow-Credentials: true');
        }
        // Access-Control headers are received during OPTIONS requests
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
                // may also be using PUT, PATCH, HEAD etc
                header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
                header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
            exit(0);
        }


        header($this->_build_http_header_string($status_code));
        header("Content-Type: application/json");
        echo json_encode($data);
        die();
    }

    protected function getRequestType()
    {
        return $_SERVER["REQUEST_METHOD"];
    }

    protected function _build_http_header_string($status_code)
    {
        $status = array(
            200 => 'OK',
            201 => 'Created',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            404 => 'Not Found',
            403 => 'Forbidden',
            405 => 'Method Not Allowed',
            500 => 'Internal Server Error'
        );
        return "HTTP/1.1 " . $status_code . " " . $status[$status_code];
    }

    protected function GetDataFromBody()
    {
        return json_decode(file_get_contents("php://input"), true);
    }

    protected function ValidDataFromRequest($listTableForAdd, $dataFromRequest)
    {
        // empty or less data
        if (empty($dataFromRequest) || (count($dataFromRequest) !== count($listTableForAdd))) {
            $this->response(400, ["code" => 400, "message" => "Data Error"]);
        }

        // check keys
        foreach ($listTableForAdd as $tableName) {
            if (!isset($dataFromRequest[$tableName])) {
                $this->response(400, ["code" => 400, "message" => "Keys Invalid"]);
            }
        }

        // check values
        foreach ($listTableForAdd as $tableName) {
            if (empty($dataFromRequest[$tableName])) {
                $this->response(400, ["code" => 400, "message" => "Data Can Not Empty"]);
            }
        }
    }

}


