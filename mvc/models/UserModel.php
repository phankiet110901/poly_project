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

    public function GetUserCart(string $userID) : array
    {
        return $this->SelectCondition('cart', ['cartID', 'cartDate', 'customerAddress', 'cartTotal', 'cartStatus'], ['userID' => $userID]);
    }

    public function CheckExistUser(string $userID) : bool
    {
        $dataFromDB = $this->SelectCondition('user', ["userID"], ["userID" => $userID]);

        if (empty($dataFromDB)) {
            return false;
        }
        return true;
    }

}