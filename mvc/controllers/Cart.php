<?php

class Cart extends Controller
{
    // Table Properties
    private $listTableName = [
        "cartID",
        "cartDate",
        "customerName",
        "customerAddress",
        "customerTelephone",
        "customerEmail",
        "cartTotal",
        "cartStatus",
        "userID"
    ];

    // Default Page
    public function DefaultPage(): void
    {
        $this->handleWrongUrl();
    }

    public function SelectAllCart(): void
    {
        $this->response(200, $this->LoadModel("CartModel")->GetAllCart());
    }

    public function DeleteCart(string $cartID = null): void
    {
        // Check method
        $this->handleWrongMethod("DELETE");

        // Check Token
        $this->HandleTokenValidate();

        // Check Empty
        if (!($cartID)) {
            $this->response(400, ["code" => 400, "message" => "cartID Can Not Be Empty"]);
        }

        if (!($this->LoadModel("CartModel")->CheckCartExist($cartID))) {
            $this->response(400, ["code" => 400, "message" => "cartID Invalid"]);
        }

        // Delete
        if ($this->LoadModel("CartModel")->DeleteCart($cartID)) {
            $this->response(201, ["code" => 201, "message" => "Action Completely Successful"]);
        }
        
        $this->response(500, ["code" => 500, "message" => "500 Internal Server"]);
    }

    public function ChangeCartStatus(string $cartID = null): void
    {
        // Check Method
        $this->handleWrongMethod("PUT");

        // Check Empty
        if(!($cartID))
        {
            $this->response(400, ["code" => 400, "message" => "cartID Can Not Be Empty"]);
        }

        // Check Exist
        if(!($this->LoadModel("CartModel")->CheckCartExist($cartID)))
        {
            $this->response(400, ["code" => 400, "message" => "cartID Invalid"]);
        }

        // Update Status
        if($this->LoadModel("CartModel")->UpdateStatus($cartID))
        {
            $this->response(200, ['code' => 200, 'message'=> 'Update Completed']);
        }

        $this->response(500, ["code" => 500, "message" => "500 Internal Server"]);
    }

    public function AddCart(string $userID = null): void
    {
        // Check method
        $this->handleWrongMethod("POST");

        // Check Token
        $this->HandleTokenValidate();

        // Get Table To Add
        $listTableToAdd = [
            $this->listTableName[2],
            $this->listTableName[3],
            $this->listTableName[4],
            $this->listTableName[5],
            $this->listTableName[6],
        ];
        $fieldID = $this->listTableName[0];
        $fieldUserID = $this->listTableName[8];

        // Read Data From Body
        $bodyData = $this->GetDataFromBody();
        $this->ValidDataFromRequest($listTableToAdd, $bodyData);

        // Prepare Data to Insert
        $dataInsert[$fieldID] = genUUIDV4();
        $dataInsert[$fieldUserID] = $userID;
        
        foreach($listTableToAdd as $tableName)
        {
            $dataInsert[$tableName] = $bodyData[$tableName];
        }

        // Prepare to Insert
        if ($this->LoadModel("CartModel")->AddCart($dataInsert)) {
            $this->response(201, ["code" => 201, "message" => "Action Completely Successful"]);
        }
        else
        {
            $this->response(400, ["code" => 400, "message" => "Data Invalid"]);
        }

        $this->response(500, ["code" => 500, "message" => "500 Internal Server"]);
    }


}
?>