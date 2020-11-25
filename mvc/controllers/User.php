<?php


class User extends Controller
{
    private $listField = ["userID", "userName", "userPassword", "name", "userEmail", "userAvatar", "userStatus", "roleName"];

    public function DefaultPage(): void
    {
        // TODO: Implement DefaultPage() method.
        $this->handleWrongUrl();
    }

    public function GetAllUser(): void
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

    public function GetAllTypeUser(): void
    {

    }

    public function EditInFoUser(string $idUser = null): void
    {
        $this->handleWrongMethod("PUT");

        if (!$idUser) {
            $this->response(400);
        }
        $this->HandleTokenValidate();

        $this->ValidDataFromRequest([
            $this->listField[3],
            $this->listField[4],
        ], $this->GetDataFromBody());


        $dataEdit = $this->GetDataFromBody();

        if (!$this->Auth('user', ['userID' => $idUser])) {
            $this->response(400, ['code' => 400, 'message' => 'Id User InValid']);
        }

        if ($this->LoadModel("UserModel")->EditUser($dataEdit, $idUser)) {
            $this->response(200, $dataEdit);
        }

        $this->response(500);

    }

    public function EditUserAvatar(string $idUser): void
    {
        $this->handleWrongMethod('POST');
        $this->HandleTokenValidate();


        if (!$this->Auth('user', ['userID' => $idUser])) {
            $this->response(400, ['code' => 400, 'message' => 'ID Invalid']);
        }

        $currentUserAvatar = $this->LoadModel("UserModel")->GetInfoUser($idUser)['userAvatar'];

        if (!$currentUserAvatar) {
            unlink($currentUserAvatar);
        }

        $res = $this->UploadImg('upload/', $_FILES, $this->listField[5]);

        if (!$res) {
            $this->response(500, ['code' => 500, 'message' => 'Failed To Upload Img']);
        }

        if ($this->LoadModel("UserModel")->EditUser(['userAvatar' => $res], $idUser)) {
            $this->response(200);
        }

        $this->response(500);


    }

    public function DeleteUser(string $idUser = null): void
    {
        $this->handleWrongMethod("DELETE");

        $this->HandleTokenValidate();

        if (!$idUser) {
            $this->response(400);
        }


        if (!$this->Auth('user', ['userID' => $idUser])) {
            $this->response(400, ['code' => 400, 'message' => 'Invalid User ID']);
        }

        $userDelAvatar = $this->LoadModel("UserModel")->GetInfoUser($idUser)['userAvatar'];

        if (!$userDelAvatar) {
            unlink($userDelAvatar);
        }

        if ($this->LoadModel('UserModel')->DeleteUser($idUser)) {
            $this->response(200);
        }

        $this->response(500);


    }

    public function ToggleStatusUser(string $idUser, string $currentStatus): void
    {
        $this->handleWrongMethod("PUT");
        $this->HandleTokenValidate();

        if (!$this->Auth('user', [$this->listField[0] => $idUser])) {
            $this->response(400, ['code' => 400, 'message' => 'Invalid ID User']);
        }

        $statusUpdate = !(bool)$currentStatus;

        if ($this->LoadModel("UserModel")->UpdateRoleForUser($idUser, $statusUpdate)) {
            $this->response(200);
        }

        $this->response(500);
    }


}