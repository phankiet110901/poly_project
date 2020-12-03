<?php


class UserModel extends DBSql
{
    public function GetAllUser($listField) : array
    {
        return $this->Select("user",$listField);
    }

    public function EditUser($dataUpdate, $idUser) : bool
    {
        return $this->Update('user',$dataUpdate,['userID' => $idUser]);
    }

    public function DeleteUser(string $idUser) : bool
    {
        $infoUser = $this->SelectCondition('user',['userAvatar'],['userID' => $idUser])[0];
        $fileUrl = str_replace("/poly_project/","", parse_url($infoUser['userAvatar'], PHP_URL_PATH));

        if(!empty($fileUrl)) {
            unlink($fileUrl);
        }

        return $this->Delete('user',['userID' => $idUser]);
    }

    public function GetInfoUser(string $idUser) : array
    {
        return $this->SelectCondition('user',['userAvatar'],['userID' => $idUser])[0];
    }

    public function UpdateRoleForUser(string $idUser, bool $newStatus) : bool
    {
        return $this->Update('user', ['userStatus' => $newStatus], ['userID' => $idUser]);
    }

    public function editUserAvatar(string $tableName, $idUser, $newAvatarUrl) : bool
    {
        return $this->Update('user',['userAvatar' => $newAvatarUrl] , ['userID' => $idUser]);
    }
}