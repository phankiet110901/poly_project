<?php

class ProductSize extends Controller{

    // Properties of Productize
    private $listTableName = [
        "sizeID",
        "sizeName"
    ];

    public function DefaultPage(): void
    {
        $this->handleWrongUrl();
    }

    public function SelectAllSize(): void
    {
        $this->response(200, $this->LoadModel("ProductSizeModel")->GetAllSize());
    }

    public function DeleteSize(string $sizeID = null): void
    {

        // Check method
        $this->handleWrongMethod("DELETE");

        // Check token
        $this->HandleTokenValidate();

        // Check Empty Or Not
        if(!($sizeID))
        {
            $this->response(400, ["code" => 400, "message" => "sizeID Can Not Be Empty"]);
        }

        // Check Exist Or Not
        if (!($this->LoadModel("ProductSizeModel")->CheckExistSize($sizeID))) {
            $this->response(400, ["code" => 400, "message" => "sizeID Invalid"]);
        }        

        // Delete Product
        if ($this->LoadModel("ProductSizeModel")->DeleteSize($sizeID)) {
            $this->response(201, ["code" => 201, "message" => "Action Completely Successful"]);
        }

        $this->response(500, ["code" => 500, "message" => "500 Internal Server"]);

    }

    public function AddSize(): void
    {

        // Check method
        $this->handleWrongMethod("POST");

        // Check Token
        $this->HandleTokenValidate();

        // Get Table To Add
        $listFieldToAdd = [$this->listTableName[1]];
        $fieldID = $this->listTableName[0]; //ProductID Generate UUID4

        // Read Data From Body
        $bodyContent = $this->GetDataFromBody();

        // Valid Data
        $this->ValidDataFromRequest($listFieldToAdd, $bodyContent);

        // Prepare Value to Insert
        $dataInsert[$fieldID] = genUUIDV4();
        foreach($listFieldToAdd as $tableName)
        {
            $dataInsert[$tableName] = $bodyContent[$tableName];
        }

        // Prepare To Insert
        if ($this->LoadModel("ProductSizeModel")->AddSize($dataInsert)) {
            $this->response(201, ["code" => 201, "message" => "Action Completely Successful"]);
        }
        else
        {
            $this->response(400, ["code" => 400, "message" => "Data Invalid"]);
        }

        $this->response(500, ["code" => 500, "message" => "500 Internal Server"]);
    }

    public function EditSize(string $sizeID = null): void
    {

        // Check Method
        $this->handleWrongMethod("PUT");

        // Check Token
        $this->HandleTokenValidate();

        // Check Empty Or Not
        if(!($sizeID))
        {
            $this->response(400, ["code" => 400, "message" => "sizeID Can Not Be Empty"]);
        }

        // Check Exist Or Not
        if (!($this->LoadModel("ProductSizeModel")->CheckExistSize($sizeID))) {
            $this->response(400, ["code" => 400, "message" => "sizeID Invalid"]);
        }        

        // Get Edit Data From Body
        $dataEdit = $this->GetDataFromBody();

        // Validate Data From Body
        $this->ValidDataFromRequest([$this->listTableName[1]],$dataEdit);

        // Edit Size
        if ($this->LoadModel("ProductSizeModel")->EditSize($sizeID, $dataEdit)) {
            $this->response(200, ["message" => "Action Completely Successful"]);
        }
        else
        {
            $this->response(400, ["code" => 400, "message" => "Data Invalid"]);
        }

    }
}

?>