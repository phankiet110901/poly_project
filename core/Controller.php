<?php

use core\JWT;

require "core/jwt.php";
abstract class Controller
{
    private $modelUrl = "./mvc/models/";
    protected $secretKey = 'KIET_DEP_TRAI_VO_DICH_VU_TRU';

    public function LoadModel($modelName): DBSql
    {
        // kiem tra model co ton tai hay khong
        if (file_exists($this->modelUrl . $modelName . ".php")) {
            require_once $this->modelUrl . $modelName . ".php";
            return new $modelName;
        }
    }

    abstract public function DefaultPage(): void;

    protected function response(int $status_code, array $data = []): string
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
        header("Content-Type: application/json; charset=utf-8");
        echo json_encode($data);
        die();
    }

    protected function getRequestType(): string
    {
        return $_SERVER["REQUEST_METHOD"];
    }

    protected function _build_http_header_string(int $status_code): string
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

    protected function ValidDataFromRequest(array $listTableForAdd, array $dataFromRequest): void
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
            if ($dataFromRequest[$tableName] == "") {
                $this->response(400, ["code" => 400, "message" => "Data Can Not Empty"]);
            }
        }
    }

    protected function getDataFromHeader(): array
    {
        return apache_request_headers();
    }

    protected function handleWrongUrl(): void
    {
        $this->response(400, ["code" => 400, "message" => "Invalid URL"]);
    }

    protected function handleWrongMethod(string $methodType): void
    {
        if ($this->getRequestType() !== $methodType) {
            $this->response(405);
        }
    }

    protected function Auth(string $tableName, array $data): bool
    {
        $db = new DBSql();
        if ($db->CountRow($tableName, $data) === 0) {
            return false;
        }
        return true;
    }

    protected function HandleTokenValidate(): object
    {
        $headerReq = $this->getDataFromHeader();
        if (!isset($headerReq['Authorization'])) {
            $this->response(401);
        }
        $token = new stdClass();
        // decode token
        try {
            $token = JWT::decode($headerReq['Authorization'], $this->secretKey);
        } catch (Exception $e) {
            $this->response(401, ['code' => 401, 'message' => 'Can Not Decode Token']);
        }

        // validate token
        if (!isset($token->time_end) || $token->time_end < getCurrentDate()) {
            $this->response(401, ['code' => 401, 'message' => 'Invalid Token']);
        }

        if (!isset($token->userID) || !isset($token->roleName)) {
            $this->response(401, ['code' => 401, 'message' => 'Invalid Token']);
        }

        if (!$this->Auth("user_role", ['roleName' => $token->roleName])) {
            $this->response(401, ['code' => 401, 'message' => 'Invalid Token']);
        }


        if (!$this->Auth("user", ['userID' => $token->userID])) {
            $this->response(401, ['code' => 401, 'message' => 'Invalid Token']);
        }

        return $token;
    }

    protected function UploadImg(string $folderUploadName, array $fileInfo, string $nameProperty): string
    {
        if (empty($fileInfo)) {
            $this->response(400, ['code' => 400, 'message' => 'File Can Not Empty']);
        }

        $listType = ["image/gif", "image/png", "image/jpg", "image/jpeg"];

        if (!array_search($fileInfo[$nameProperty]['type'], $listType)) {
            $this->response(400, ['code' => 400, 'message' => 'File Upload Is Not Image']);
        }

        if ($fileInfo[$nameProperty]['error'] !== 0) {
            $this->response(400, ['code' => 400, 'message' => 'File Error']);
        }

        // get and decode file name to base64
        $fileName = $fileInfo[$nameProperty]['name'];
        $fileName = explode('.', $fileName);

        // check format name file
        if (count($fileName) !== 2) {
            $this->response(400, ['code' => 400, 'message' => 'Wrong Format Name File']);
        }

        $fileName[0] = str_replace('=', '', base64_encode($fileName[0]));
        $fileName = implode('.', $fileName);
        $resUpload = move_uploaded_file($fileInfo[$nameProperty]['tmp_name'], $folderUploadName . $fileName);

        if (!$resUpload) {
            return '';
        }

        return $folderUploadName.$fileName;
    }

    protected function encodeBcryptString(string $inputString) : string
    {
        return password_hash($inputString, PASSWORD_BCRYPT);;
    }
}


