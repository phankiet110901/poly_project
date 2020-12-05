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

    // Subtable
    private $listSubTable = [
        "ID",
        "cartID",
        "productID",
        "sizeName",
        "quantity"
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

    public function AddCart(): void
    {
        // Check method
        $this->handleWrongMethod("POST");

        // Check Token
        $token = $this->HandleTokenValidate();

        // Get Table To Add
        $listTableToAdd = [
            $this->listTableName[2],
            $this->listTableName[3],
            $this->listTableName[4],
            $this->listTableName[5],
            $this->listTableName[6],
            $this->listTableName[8]
        ];
        $fieldID = $this->listTableName[0];

        // Get userID and Name From token
        $userID = $token->userID;
        $customerName = $token->name;

        // Read Data From Body
        $bodyData = $this->GetDataFromBody();

        // Define
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
            $this->response(201, ["code" => 201, "cartID" => $dataInsert['cartID']]);
        }
        else
        {
            $this->response(400, ["code" => 400, "message" => "Data Invalid"]);
        }

        $this->response(500, ["code" => 500, "message" => "500 Internal Server"]);
    }

    public function AddCartDetail(string $cartID = null): void
    {
        // Check Method
        $this->handleWrongMethod("POST");

        // Validate Token
        $this->HandleTokenValidate();

        // Check CartID Empty
        if (!($cartID)) {
            $this->response(200, ['code' => 200, 'message' => 'cartID Can Not Be Empty']);
        }

        // Check Exist
        if (!($this->LoadModel("CartModel")->CheckCartExist($cartID))) {
            $this->response(200, ['code' => 200, 'message' => 'cartID Invalid']);
        }

        // Get Table To Add
        $listTableToAdd = [
            $this->listSubTable[1],
            $this->listSubTable[2],
            $this->listSubTable[3],
            $this->listSubTable[4],
        ];
        $fieldID = $this->listSubTable[0];
        
        // Read Data From Body
        $bodyContent = $this->GetDataFromBody();

        // Loop Throught bodyContent To Validate
        for ($i=0; $i < count($bodyContent); $i++) { 
            $bodyContent[$i]['cartID'] = $cartID;
            // Check Quantity And Product
            if (!($this->LoadModel("ProductModel")->CheckExistProduct($bodyContent[$i]['productID']))) {
                $this->response(200, ['code' => 400 ,'message' => 'Invalid ProductID']); die();
            }
            if ($bodyContent[$i]['quantity'] < 1) {
                $this->response(200, ['code' => 400, 'message' => 'Invalid Quantity']); die();
            }
            if ($bodyContent[$i]['sizeName'] == "") {
                $this->response(200, ['code' => 400, 'message' => 'Invalid Size']); die();
            }
            // Validate Data
            $this->ValidDataFromRequest($listTableToAdd, $bodyContent[$i]);
        }

        // Prepare Values To Insert
        for ($i=0; $i < count($bodyContent); $i++) { 
            $bodyContent[$i][$fieldID] = genUUIDV4();

            if($this->LoadModel("CartModel")->AddCartDetail($bodyContent[$i]))
            {
                $flag = true;
            }
            else $flag = false;
        }

        // Check
        ($flag === true) ? $this->response(201, ['code' => 201, 'message' => 'Insert Completed']) : $this->response(400, ['code' => 400, 'message' => 'Error During Insert']);
       
        $this->response(500, ["code" => 500, "message" => "500 Internal Server"]);
    }

}
?>