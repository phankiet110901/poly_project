<?php
use core\JWT;
class Comment extends Controller{

    // Properties Of Comment
    private $listTableName = [
        "commentID" ,
        "commentDate" ,
        "commentText" ,
        "productID" ,
        "userID" ,
        "commentStatus"
    ];

    public function DefaultPage(): void
    {
        $this->handleWrongUrl();
    }

    public function SelectAllComment(): void
    {
        $data = $this->LoadModel('CommentModel')->GetAllProduct();

        
        foreach ($data as $key => $value) {
            // Get Product Comment
            $comment = $this->LoadModel("CommentModel")->GetCommentProduct($value['productID']);

            $data[$key]['comment'] = $comment;
        }

        $this->response(200, $data);
    }

    public function SelectCommentProduct(string $productID = null): void
    {
        // Check Empty Or Not
        if (!($productID)) {
            $this->response(400, ["code" => 400, "message" => "productID Can Not Be Empty"]);
        }
        
        // Check Exist Or Not
        if (!($this->LoadModel("ProductModel")->CheckExistProduct($productID))) {
             $this->response(400, ["code" => 400, "message" => "productID Invalid"]);
        }

        //Get ProductData 
        $data = $this->LoadModel("CommentModel")->GetProductField($productID);

        // Get Comment Related To Product
        $comment = $this->LoadModel("CommentModel")->GetCommentProduct($productID);

        // Set Comment For Product
        $data[0]['comment'] = $comment;

        // Respond Data
        $this->response(200, $data);
    }

    public function AddComment(): void
    {
        // Check Method
        $this->handleWrongMethod("POST");

        // Check Token
        $token = $this->HandleTokenValidate();

        // Read Data From Body
        $bodyContent = $this->GetDataFromBody();
                        
        // Get userID From Token
        $userID = $token->userID;

        $bodyContent['userID'] = $userID;

        // Check Valid ProductID
        if (!($this->LoadModel("ProductModel")->CheckExistProduct($bodyContent['productID']))) {
            $this->response(400, ['code'=>400, 'message'=>'productID Invalid']);
        }

        // Get Table To Add
        $listFieldToAdd = [
            $this->listTableName[2],
            $this->listTableName[3],
            $this->listTableName[4]
        ];
        $fieldID = $this->listTableName[0];

        // Valid Data
        $this->ValidDataFromRequest($listFieldToAdd, $bodyContent);

        // Prepare Values To Insert
        $dataInsert[$fieldID] = genUUIDV4();

        foreach ($listFieldToAdd as $tableName) {
            $dataInsert[$tableName] = $bodyContent[$tableName];
        }

        // Prepare to Insert
        if ($this->LoadModel("CommentModel")->AddComment($dataInsert)) {
            $this->response(201, ["code" => 201, "message" => "Action Completely Successful"]);
        }
        else
        {
            $this->response(400, ["code" => 400, "message" => "Data Invalid"]);
        }        

        $this->response(500, ["code" => 500, "message" => "500 Internal Server"]);
    }

    public function EditComment(string $commentID = null): void
    {
        // Check method
        $this->handleWrongMethod("PUT");

        // Check Token
        $this->HandleTokenValidate();

        // Check Empty Or Not
        if (!($commentID)) {
            $this->response(400, ["code" => 400, "message" => "commentID Can Not Be Empty"]);
        }
                
        // Check Exist Or Not
        if (!($this->LoadModel("CommentModel")->CheckExistComment($commentID))) {
             $this->response(400, ["code" => 400, "message" => "commentID Invalid"]);
        }

        // Get Edit Data From Body
        $dataEdit = $this->GetDataFromBody();

        // Validate Data From Body
        $this->ValidDataFromRequest([$this->listTableName[2]], $dataEdit);

        // Edit Comment
        if ($this->LoadModel("CommentModel")->EditComment($commentID, $dataEdit)) {
            $this->response(200, ["message" => "Action Completely Successful"]);
        } else {
            $this->response(400, ["code" => 400, "message" => "Data Invalid"]);
        }

        $this->response(500, ["code" => 500, "message" => "500 Internal Server"]);
        
    }

    public function DeleteComment(string $commentID = null): void
    {
        // Check Method
        $this->handleWrongMethod("DELETE");

        // Check Token
        $this->HandleTokenValidate();

        // Check Empty Or Not
        if (!($commentID)) {
            $this->response(400, ["code" => 400, "message" => "productID Can Not Be Empty"]);
        }
        
        // Check Exist Or Not
        if (!($this->LoadModel("CommentModel")->CheckExistComment($commentID))) {
             $this->response(400, ["code" => 400, "message" => "productID Invalid"]);
        }

        // Delete Comment
        if ($this->LoadModel("CommentModel")->DeleteComment($commentID)) {
             $this->response(201, ["code" => 201, "message" => "Action Completely Successful"]);
        }
        
        $this->response(500, ["code" => 500, "message" => "500 Internal Server"]);
    }
}

?>
