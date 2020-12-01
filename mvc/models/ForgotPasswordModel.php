<?php
class ForgotPasswordModel extends DBSql{

    // Table Name
    private $tableName = 'user';

    public function CheckExistEmail(string $userEmail): bool
    {
        $dataFromDB = $this->SelectCondition($this->tableName, ['userEmail'], ['userEmail' => $userEmail]);

        if (empty($dataFromDB)) {
            return false;
        }

        return true;
    }

    public function GetUserId(string $userEmail): array
    {
        return $this->SelectCondition($this->tableName, ['userID'], ['userEmail' => $userEmail])[0];
    }

    public function ResetPassword(string $userID, array $dataEdit): bool
    {
        return $this->Update($this->tableName, $dataEdit, ['userID' => $userID]);
    }
}

?>