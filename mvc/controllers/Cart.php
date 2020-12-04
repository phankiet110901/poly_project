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
        else
        {
            $this->response(500, ["code" => 500, "message" => "500 Internal Server"]);
        }
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
        $this->LoadModel("CartModel")->UpdateStatus($cartID);
    }

    public function AddCart(string $userID = null): void
    {
        // Check method
        $this->handleWrongMethod("POST");

        // Check Token
        $token = $this->HandleTokenValidate();

        // Get Table To Add
        $listTableToAdd = [
            $this->listTableName[2], // Name
            $this->listTableName[3], // Address
            $this->listTableName[4], // Telephone
            $this->listTableName[5], // Email
            $this->listTableName[6], // Total
            $this->listTableName[8]  // userID
        ];
        $fieldID = $this->listTableName[0];

        // Read Data From Body
        $bodyData = $this->GetDataFromBody();

        // Get userID From Token
        $userID = $token->userID;
        $customerName = $token->name;

        // Insert Value To bodyData
        $bodyData['userID'] = $userID;
        $bodyData['customerName'] = $customerName;

        // Validate Data
        $this->ValidDataFromRequest($listTableToAdd, $bodyData);

        // Prepare Data to Insert
        $dataInsert[$fieldID] = genUUIDV4();
        
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
    }


}
?>