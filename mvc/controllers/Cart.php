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
        "quantity"
    ];

    // Default Page
    public function DefaultPage(): void
    {
        $this->handleWrongUrl();
    }

    public function SelectAllCart(): void
    {
        $data = $this->LoadModel("CartModel")->GetAllCart();

        foreach($data as $key => $value)
        {
            $dataProduct = $this->LoadModel("CartModel")->GetDetailCart($value['cartID']);

            $data[$key]['data'] = $dataProduct;
        }

        $this->response(200, $data);
    }

    public function SelectRecentCart(): void
    {
        $data = $this->LoadModel("CartModel")->GetRecentCart();

        foreach($data as $key => $value)
        {
            $dataProduct = $this->LoadModel("CartModel")->GetDetailCart($value['cartID']);

            $data[$key]['data'] = $dataProduct;
        }

        $this->response(200, $data);
    }

    public function SelectCartDetail(string $cartID = null): void
    {
        // Check Empty
        if (!($cartID)) {
            $this->response(400, ['code' => 400, 'message' => 'cartID Can Not Be Empty']);
        }

        // Check Exist
        if (!($this->LoadModel("CartModel")->CheckCartExist($cartID))) {
            $this->response(400, ['code' => 400, 'message' => 'cartID Invalid']);
        }

        // Get carData
        $data = $this->LoadModel("CartModel")->GetOneCart($cartID);

        // Get cartDetail
        $data[0]['data'] = $this->LoadModel("CartModel")->GetDetailCart($cartID);;

        $this->response(200, $data);
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
        if ($this->LoadModel("CartModel")->DeleteCart($cartID) && $this->LoadModel("CartModel")->DeleteCartDetail($cartID)) {
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

        // Get DataCart
        $dataCart = $bodyData['data'];

        // Check Empty
        if (empty($dataCart)) {
            $this->response(400, ['code' => 400, 'message' => 'Cart Can Not Be Empty']);
        }
        
        // Unset $bodyData['data]
        unset($bodyData['data']);

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

             // Get Table To Add
            $listTableToAdd = [
                    $this->listSubTable[1],
                    $this->listSubTable[2],
                    $this->listSubTable[3],
                    ];
            $fieldID = $this->listSubTable[0];

            // Loop Throught dataCart To Validate
            for ($i=0; $i < count($dataCart); $i++) { 
            $dataCart[$i]['cartID'] = $dataInsert['cartID'];
            // Check Quantity And Product
            if (!($this->LoadModel("ProductModel")->CheckExistProduct($dataCart[$i]['productID']))) {
                $this->response(400, ['code' => 400 ,'message' => 'Invalid ProductID']);
            }
            if ($dataCart[$i]['quantity'] < 1) {
                $this->response(400, ['code' => 400, 'message' => 'Invalid Quantity']);
            }
            // Validate Data
            $this->ValidDataFromRequest($listTableToAdd, $dataCart[$i]);
            }

            // Prepare Values To Insert
            for ($i=0; $i < count($dataCart); $i++) { 
            $dataCart[$i][$fieldID] = genUUIDV4();

            if($this->LoadModel("CartModel")->AddCartDetail($dataCart[$i]))
            {
                $flag = true;
            }
            else $flag = false;
             }
            // Check
            ($flag === true) ? $this->response(201, ['code' => 201, 'message' => 'Insert Completed']) : $this->response(400, ['code' => 400, 'message' => 'Error During Insert']);
   
        }
        else
        {
            $this->response(400, ["code" => 400, "message" => "Data Invalid"]);
        }

        $this->response(500, ["code" => 500, "message" => "500 Internal Server"]);
    }

}
?>