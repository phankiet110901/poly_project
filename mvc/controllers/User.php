<?php


class User extends Controller
{
    private $listField = ["userID", "userName", "userPassword", "name", "userEmail", "userAvatar", "userStatus", "roleName"];

    public function DefaultPage(): void
    {
        // TODO: Implement DefaultPage() method.
        $this->handleWrongUrl();
    }

    public function GetAllUser() : void
    {
        $dataRes = $this->LoadModel("UserModel")->GetAllUser([
            $this->listField[0],
            $this->listField[1],
            $this->listField[3],
            $this->listField[4],
            $this->listField[5],
            $this->listField[6],
            $this->listField[7],
        ]);

        $this->response(200, $dataRes);
    }

    public function GetAllTypeUser() : void
    {

    }
    
}