<?php


class UserModel extends DBSql
{
    public function GetAllUser($listField) : array
    {
        return $this->Select("user",$listField);
    }
}