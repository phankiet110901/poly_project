<?php

use core\JWT;


class Authorization extends Controller
{
    private $listField = ["userID", "userName", "userPassword", "name", "userEmail", "userAvatar", "userStatus", "roleName"];

    public function DefaultPage(): void
    {
        // TODO: Implement DefaultPage() method.
        $this->handleWrongUrl();
    }

    public function Login(): void
    {
        $this->handleWrongMethod("POST");

        $dataFromBody = $this->GetDataFromBody(); // get data send from client
        $this->ValidDataFromRequest([$this->listField[1], $this->listField[2]], $dataFromBody); // validate data

        $resLogin = $this->LoadModel("AuthModel")->Auth([$this->listField[1] => $dataFromBody['userName']]);

        if (!$resLogin) {
            $this->response(400, ['code' => 400, 'message' => 'Data Invalid']);
        }

        // get data from db
        $dataFromDB = $this->LoadModel("AuthModel")->GetInFoUserLogin([$this->listField[1] => $dataFromBody[$this->listField[1]]]);

        if (!password_verify($dataFromBody['userPassword'], $dataFromDB[$this->listField[2]])) {
            $this->response(400, ['code' => 400, 'message' => 'Wrong Password']);
        }
        unset($dataFromDB['userPassword']);
        $dataFromDB['token'] = JWT::encode(
            array_merge($dataFromDB, [
                'time_start' => getCurrentDate(),
                'time_end' => addDay(getCurrentDate(), 30)
            ]),
            $this->secretKey
        );
        $this->response(200, array_slice($dataFromDB, 1));
    }

    public function Register(string $typeUser = null): void
    {
        $this->handleWrongMethod("POST");

        if (!$typeUser) {
            $this->response(400);
        }

        $listTypeFromDB = $this->LoadModel("AuthModel")->GetAllRoleUser();

        $listType = [];

        foreach ($listTypeFromDB as $value) {
            $listType[$value['roleName']] = $value['roleName'];
        }

        if (!isset($listType[$typeUser])) {
            $this->response(400, ['code' => 400, 'message' => 'Invalid Type User']);
        }

        if ($typeUser != 'Memer') {
//            $this->HandleTokenValidate();
        }

        $dataRegister = $this->GetDataFromBody();
        $listFieldToAdd = [
            $this->listField[1],
            $this->listField[2],
            $this->listField[3],
            $this->listField[4],
        ];
        $this->ValidDataFromRequest($listFieldToAdd, $dataRegister);

        // check exist user name
        if ($this->Auth('user', [$this->listField[1] => $dataRegister['userName']])) {
            $this->response(400, ['code' => 400, 'message' => 'UserName Already Exists']);
        }

        $dataRegister["roleName"] = $listType[$typeUser];
        $dataRegister["userID"] = genUUIDV4();
        $dataRegister["userPassword"] = $this->encodeBcryptString($dataRegister['userPassword']);
        $resAdd = $this->LoadModel("AuthModel")->AddUser($dataRegister);

        if ($resAdd) {
            $this->response(200, ["idUser" => $dataRegister["userID"]]);
        }

        $this->response(500);
    }

    public function UploadAvatar(string $typeUser, string $idNewUser = null): void
    {
        $this->handleWrongMethod("POST");

        if (!$typeUser || !$idNewUser) {
            $this->response(400);
        }

        if ($typeUser === "Administrator") {
            $this->HandleTokenValidate();
        }

        if (!$idNewUser) {
            $this->response(400, ['code' => 400, 'message' => 'Unknown ID User']);
        }

        // handle upload and save file
        $pathFileUpload = $this->UploadImg('upload/',$_FILES,$this->listField[5]);

        $pathFileUpload = "https://52.237.89.87/".$pathFileUpload;

        // insert into database
        if(!$pathFileUpload){
            $this->response(500, ['code' => 500, 'message' => 'Can Not Handle File Upload']);
        }

        if ($this->LoadModel("AuthModel")->SetAvatarForUser($pathFileUpload, $idNewUser)) {
            $this->response(200);
        }

        $this->response(500);

    }


}