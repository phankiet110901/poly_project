<?php


class AuthModel extends DBSql
{
    private $tableName = "user";

    public function Auth(array $dataCheck): bool
    {
        $auth = $this->CountRow($this->tableName, $dataCheck);

        if ($auth === 0) {
            return false;
        }

        return true;
    }

    public function GetInFoUserLogin(array $infoData): array
    {
        return $this->SelectCondition($this->tableName, ["userID", "userName","userPassword", "name", "userAvatar", "userStatus", "roleName"], $infoData)[0];
    }

    public function GetAllRoleUser() : array
    {
        return $this->SelectAll("user_role");
    }

    public function SetAvatarForUser(string $linkImg, string $idUser) : bool
    {
        return $this->Update('user',['userAvatar' => $linkImg],['userID' => $idUser]);
    }

    public function AddUser(array $dataUser) : bool
    {
        return $this->Insert('user',$dataUser);
    }
}