<?php


class User extends Controller
{
    private $listField = ["userID", "userName", "userPassword", "name", "userEmail", "userAvatar", "userStatus", "roleName"];
    private $absolutePath = "http://104.215.156.152/poly_project/";

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
        $fileUrl = str_replace("/poly_project/","", parse_url($currentUserAvatar, PHP_URL_PATH));
        if (!empty($currentUserAvatar) && file_exists($fileUrl)) {
            unlink($fileUrl);
        }

        $res = $this->UploadImg('upload/user/', $_FILES, $this->listField[5]);

        $newPathFileUpload = $this->absolutePath.$res;

        if (!$res) {
            $this->response(500, ['code' => 500, 'message' => 'Failed To Upload Img']);
        }

        if ($this->LoadModel("UserModel")->EditUser(['userAvatar' => $newPathFileUpload], $idUser)) {
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

        // Get Image
        $infoUser = $this->LoadModel("UserModel")->GetInfoUser($idUser);
        $fileUrl = str_replace("/poly_project/","", parse_url($infoUser['userAvatar'], PHP_URL_PATH));

        if ($this->LoadModel('UserModel')->DeleteUser($idUser)) {
            if(!empty($fileUrl) && file_exists($fileUrl)) {
                unlink($fileUrl);
            }
            $this->response(201);
        }
        else
        {
            $this->response(400, ['code' => 400, 'message' => 'You must remove user comments before deleting this user']);
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

    public function ChangePassword(): void
    {
        // Check Method
        $this->handleWrongMethod("PUT");

        // Check Token
        $token = $this->HandleTokenValidate();

        // Get userID From Token
        $userID = $token->userID;

        // Check exist
        if (!$this->Auth('user', ['userID' => $userID])) {
            $this->response(400, ['code' => 400, 'message' => 'UserID InValid']);
        }

        // Read Edit Data From Body
        $bodyData = $this->GetDataFromBody();

        if (count($bodyData) === 0) {
            $this->response(400, ['code' => 400, 'message' => "Data Empty"]);
        }
        else
        {
            $currentPassword = preg_replace('/\s+/','', trim($bodyData['currentPassword']));
            $newPassword = preg_replace('/\s+/','', trim($bodyData['newPassword']));
            $repeatNewPassword = preg_replace('/\s+/','', trim($bodyData['repeatNewPassword']));

            $passwordFromDB = $this->LoadModel("UserModel")->GetPasswordUser($userID)['userPassword'];
            
            // Check Password From DB
            if(!(password_verify($currentPassword, $passwordFromDB)))
            {
                $this->response(400, ['code' => 400, 'message' => 'PASSWORD DOES NOT MATCH']);
            }

            if ($newPassword != $repeatNewPassword) {
                $this->response(400, ['code' => 400, 'message' => "NEW PASSWORD DOES NOT MATCH WITH REPEAT PASSWORD"]);
            }

            $newPassword = $this->encodeBcryptString($newPassword);

            $dataEdit['userPassword'] = $newPassword;

            // Validate Data From Body
            $this->ValidDataFromRequest([$this->listField[2]], $dataEdit);

            // Change Password
            if ($this->LoadModel("UserModel")->EditUser($dataEdit, $userID)) {
                $this->response(200, ["code" => 200, "message" => "Update Password Completed"]);
            }
            else
            {
                $this->response(500, ["code" => 400, "message" => "Error, Can't Update Password"]);
            }
        }

        // Callback ON BackEnd
        $this->response(500, ["code" => 500, "message" => "500 Internal Server"]);
    }

    public function GetUserCart() : void
    {
        // Check Token
        $token = $this->HandleTokenValidate();

        $idUser = $token->userID;

        // Check Exist User
        if (!($this->LoadModel("UserModel")->CheckExistUser($idUser))) {
            $this->response(400, ['code' => 400, 'message' => 'userID Invalid']);
        }

        $dataRes = $this->LoadModel("UserModel")->GetUserCart($idUser);

        $this->response(200, $dataRes);
    }
}