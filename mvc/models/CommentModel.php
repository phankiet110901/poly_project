<?php

class CommentModel extends DBSql{
    
    // Table Name
    private $tableName = "comment";

    // Get All Comments
    public function GetAllComment(): array
    {
        return $this->SelectAll($this->tableName);
    }

    // Get All Comment By Product
    public function GetCommentProduct($productID): array
    {
        return $this->SelectAllCondition($this->tableName, ["productID" => $productID]);
    }

    // Delete Comment
    public function DeleteComment(string $commentID) : bool
    {
        return $this->Delete($this->tableName,["commentID" => $commentID]);
    }

    public function AddComment(array $dataComment) : bool
    {
        return $this->Insert($this->tableName, $dataComment);
    }

    public function EditComment(string $commentID, array $dataEdit): bool
    {
        return $this->Update($this->tableName, $dataEdit, ["commentID" => $commentID]);
    }

    // Check Exist Comment
    public function CheckExistComment(string $commentID) : bool
    {
        $dataFromDB = $this->SelectCondition($this->tableName, ["commentID"], ["commentID" => $commentID]);

        if (empty($dataFromDB)) {
            return false;
        }
        return true;
    }

}

?>