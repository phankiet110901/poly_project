<?php

class GetProductByTool extends Controller
{
    // Properties of Product
    private $listTableName = [
    "productID",
    "productDate",
    "productName",
    "productImg",
    "productPrice",
    "productDiscount",
    "productQuantity",
    "productDescription",
    "productView",
    "productStatus",
    "catalogID"
     ];
     
    //  Default Page
    public function DefaultPage(): void
    {
        //TOTO: Implement defaultpage() method.
        $this->handleWrongUrl();
    }

    public function AddProduct(): void
    {
        // Check Method
        $this->handleWrongMethod("POST");

        // Get List Field To Add
        $listFieldToAdd = [
            $this->listTableName[2], //Name
            $this->listTableName[3], //ProductImg
            $this->listTableName[4], //Price
            $this->listTableName[7], //Description
        ];
        $fieldID = $this->listTableName[0];

        // Read Data From BodyContent
        $bodyContent = $this->GetDataFromBody();

        
        // empty or less data
        $this->ValidDataFromRequest($listFieldToAdd, $bodyContent);

        // Prepare Values TO Insert
        $dataInsert[$fieldID] = genUUIDV4();
        $dataInsert['catalogID'] = json_encode([
            "catalogID" => "f3ab4f52-22a5-11eb-8822-309c23de2ee2",
            "catalogName" => "Man"]);
        $dataInsert['productDiscount'] = 0;
        $dataInsert['productQuantity'] = 1;
        $dataInsert['productStatus'] = false;
        
        foreach($listFieldToAdd as $tableName)
        {
            $dataInsert[$tableName] = $bodyContent[$tableName];
        }

        // Prepare to Insert
        if ($this->LoadModel("ProductModel")->AddProduct($dataInsert)) {
            $this->response(201, ["code" => 201, "message" => "Action Completely Successful"]);
        }
        else
        {
            $this->response(400, ["code" => 400, "message" => "Data Invalid"]);
        }        

    }
}
?>