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
        return $this->SelectCondition($this->tableName, ['userID', 'commentText'], ['productID' => $productID]);
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

    public function UpdateStatus(string $commentID) : bool
    {
        return $this->CustomQuery("UPDATE comment SET commentStatus = (CASE WHEN commentStatus = 0 THEN 1 ELSE 0 END) WHERE commentID = '$commentID'");
    }

    public function GetProductField(string $productID) : array
    {
        return $this->SelectCondition('product',['productID', 'productName', 'productPrice'], ['productID' => $productID]);
    }

    public function GetAllProduct(): array
    {
        return $this->Select('product', ['productID', 'productName', 'productPrice']);
    }
}
?>