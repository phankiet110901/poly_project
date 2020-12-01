<?php

class Product extends Controller{

    // Properties of Product
    private $listTableName = ["productID",
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

    public function DefaultPage(): void
    {
        //TOTO: Implement defaultpage() method.
        $this->handleWrongUrl();
    }

    public function SelectAllProduct(): void
    {
        $this->response(200, $this->LoadModel("ProductModel")->GetAllProduct());
    }

    public function SelectOneProduct(string $productID = null): void
    {
        // Check Empty Or Not
        if (!($productID)) {
            $this->response(400, ["code" => 400, "message" => "productID Can Not Be Empty"]);
        }

        // Check Exist Or Not
        $res = $this->LoadModel("ProductModel")->CheckExistProduct($productID);
        if (!($res)) {
            $this->response(400, ["code" => 400, "message" => "productID Invalid"]);
        }

        // Select One Product
        $this->LoadModel("ProductModel")->IncreaseView($productID);
        $this->response(200, $this->LoadModel("ProductModel")->GetOneProduct($productID));

    }

    public function SelectProductCatalog(string $catalogID = null): void
    {
        // Check Empty Or Not
        if (!($catalogID)) {
            $this->response(400, ["code" => 400, "message" => "catalogID Can Not Be Empty"]);
        }

        // Check Exist Or Not
        $res = $this->LoadModel("CatalogModel")->CheckExistCatalog($catalogID);
        if (!($res)) {
            $this->response(400, ["code" => 400, "message" => "catalogID Invalid"]);
        }
        
        // Select Product By Catalog
        $this->response(200, $this->LoadModel("ProductModel")->GetProductByCatalog($catalogID));
    }

    public function AddProduct(): void
    {
        // Check Method
        $this->handleWrongMethod("POST");

        // Check Token
        $this->HandleTokenValidate();

        // Get Table To Add
        $listFieldToAdd = [
            $this->listTableName[2], //Name
            $this->listTableName[4], //Price
            $this->listTableName[5], //Discount
            $this->listTableName[6], //Quantity
            $this->listTableName[7], //Description
            $this->listTableName[10] //catalogID
        ];

        // Read Data From Body
        $bodyContent = $this->GetDataFromBody();

        // Validate Data
        $this->ValidDataFromRequest($listFieldToAdd, $bodyContent);

        $getCatalogName = $this->LoadModel("ProductModel")->CheckExistCatalog($bodyContent['catalogID']);
        //Validate Catalog
        if (!$getCatalogName) {
            $this->response(400, ['code'=> 400, 'message' => 'invalid catalogID']);
        }
        
        // Prepare Values To Insert
        $dataInsert = $bodyContent;
        $dataInsert['productID'] = genUUIDV4();
        $dataInsert['catalogName'] = $getCatalogName;
        
        // Prepare to Insert
        if ($this->LoadModel("ProductModel")->AddProduct($dataInsert)) {
            $this->response(201, ["code" => 201, "message" => "Action Completely Successful"]);
        }

        $this->response(500, ['code' => 500]);
    }

    public function EditProduct(string $productID = null): void
    {
        // Check Method
        $this->handleWrongMethod("PUT");

        // Check Token
        $this->HandleTokenValidate();

        // Check Empty Or Not
        if (!($productID)) {
            $this->response(400, ["code" => 400, "message" => "productID Can Not Be Empty"]);
        }

        // Check Exist Or Not
        if (!($this->LoadModel("ProductModel")->CheckExistProduct($productID))) {
            $this->response(400, ["code" => 400, "message" => "productID Invalid"]);
        }

        // Get Edit Data From Body
        $dataEdit = $this->GetDataFromBody();

        // Validate Data From Body
        $this->ValidDataFromRequest([$this->listTableName[2],
        $this->listTableName[4],
        $this->listTableName[5],
        $this->listTableName[6],
        $this->listTableName[7],
        $this->listTableName[8],
        $this->listTableName[10]
        ], $dataEdit);

        $getCatalogName = $this->LoadModel("ProductModel")->CheckExistCatalog($dataEdit['catalogID']);
        //Validate Catalog
        if (!$getCatalogName) {
            $this->response(400, ['code'=> 400, 'message' => 'invalid catalogID']);
        }
        $dataEdit['catalogName'] = $getCatalogName;
        
        // Edit Product
        if ($this->LoadModel("ProductModel")->EditProduct($productID, $dataEdit)) {
            $this->response(200, ["message" => "Action Completely Successful"]);
        } else {
            $this->response(400, ["code" => 400, "message" => "Data Invalid"]);
        }
        
    }

    public function ChangeProductStatus(string $productID = null) : void
    {
        // Check Method
        $this->handleWrongMethod("PUT");

        // Check Token
        $this->HandleTokenValidate();

        // Check Empty Or Not
        if (!($productID)) {
            $this->response(400, ["code" => 400, "message" => "productID Can Not Be Empty"]);
        }

        // Check Exist Or Not
        if (!($this->LoadModel("ProductModel")->CheckExistProduct($productID))) {
            $this->response(400, ["code" => 400, "message" => "productID Invalid"]);
        }

        $this->LoadModel("ProductModel")->UpdateStatus($productID);
    }

    public function DeleteProduct(string $productID = null): void
    {
        // Check Method
        $this->handleWrongMethod("DELETE");

        // Check Token
        $this->HandleTokenValidate();

        // Check Empty Or Not
        if (!($productID)) {
             $this->response(400, ["code" => 400, "message" => "productID Can Not Be Empty"]);
        }
        
        // Check Exist Or Not
        if (!($this->LoadModel("ProductModel")->CheckExistProduct($productID))) {
            $this->response(400, ["code" => 400, "message" => "productID Invalid"]);
        }

        // Delete Product
        if ($this->LoadModel("ProductModel")->DeleteProduct($productID)) {
            $this->response(201, ["code" => 201, "message" => "Action Completely Successful"]);
        }
        else
        {
            $this->response(400, ["code" => 400, "message" => "You must remove comment related to this product to delete"]);
        }
        $this->response(500, ["code" => 500, "message" => "500 Internal Server"]);
    }

    public function UploadProductImg(string $productID = null) : void
    {
        // Check Method
        $this->handleWrongMethod("POST");

        // Check Token
        $this->HandleTokenValidate();

        // Get Absolute Path
        $absolutePath = "https://52.237.89.87/poly_project/";

        // Check Empty Or Not
        if (!($productID)) {
            $this->response(400, ["code" => 400, "message" => "productID Can Not Be Empty"]);
        }

        // Handling FileUpload
        $pathFileUpload= $this->UploadImg('upload/products/',$_FILES,$this->listTableName[3]);

        // insert into database
        if(!$pathFileUpload){
            $this->response(500, ['code' => 500, 'message' => 'Can Not Handle File Upload']);
        }

        // Get Absolute Path
        $pathFileUpload = $absolutePath.$pathFileUpload;

        if ($this->LoadModel("ProductModel")->AddImageProduct($pathFileUpload, $productID)) {
            $this->response(200);
        }

        $this->response(500);
        
    }

    public function EditProductImg(string $productID = null): void
    {
        // Check method
        $this->handleWrongMethod("POST");

        // Check Token
        $this->HandleTokenValidate();

        // Get Absolute Path
        $newPathFileUpload = "https://52.237.89.87/poly_project/";

        // Delete Old Image
        $currentProductImg = $this->LoadModel("ProductModel")->GetImageProduct($productID)['productImg'];
        $fileUrl = str_replace("/poly_project/","", parse_url($currentProductImg, PHP_URL_PATH));
        if (!empty($currentProductImg) && file_exists($fileUrl)) {
            unlink($fileUrl);
        }

        // Upload New Image
        $res = $this->UploadImg('upload/products/', $_FILES, $this->listTableName[3]);

        if (!$res) {
            $this->response(500, ['code' => 500, 'message' => 'Failed To Upload Img']);
        }

        $res = $newPathFileUpload.$res;
        if ($this->LoadModel("ProductModel")->EditProduct($productID, ['productImg' => $res])) {
            $this->response(200);
        }

        $this->response(500);
    }
}