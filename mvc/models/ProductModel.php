<?php
class ProductModel extends DBSql{
    private $tableName = "product";

    // Get All Products
    public function GetAllProduct() : array
    {
        return $this->SearchQuery("SELECT product.*, product_catalog.catalogName as 'catalogName' FROM `product` INNER JOIN product_catalog ON product.catalogID = product_catalog.catalogID;");
    }

    // Select One Product
    public function GetOneProduct(string $productID) : array
    {
        return $this->SelectAllCondition($this->tableName, ["productID" => $productID]);
    }

    //Select Most View Product
    public function GetFamousProduct() : array
    {
        return $this->SearchQuery("SELECT product.*, product_catalog.catalogName as 'catalogName' FROM `product` INNER JOIN product_catalog ON product.catalogID = product_catalog.catalogID ORDER BY `productView` DESC LIMIT 10;");
    }

    // Select Product By Catalog
    public function GetProductByCatalog(string $catalogID) :array
    {
        return $this->SelectAllCondition($this->tableName, ["catalogID" => $catalogID]);
    }

    // Get Low Quantity Product
    public function GetLowQuantityProduct() : array
    {
        return $this->SearchQuery("SELECT product.*, product_catalog.catalogName as 'catalogName' FROM `product` INNER JOIN product_catalog ON product.catalogID = product_catalog.catalogID WHERE product.productQuantity < 10;");
    }

    // Add New Product
    public function AddProduct(array $dataProduct) : bool
    {
        return $this->Insert($this->tableName, $dataProduct);
    }


    // Edit Product
    public function EditProduct(string $productID, array $dataEdit): bool
    {
        return $this->Update($this->tableName,$dataEdit,["productID" => $productID]);
    }

    // Delete Product
    public function DeleteProduct(string $productID) : bool
    {
        return $this->Delete($this->tableName, ["productID" => $productID]);
    }

    // Increase View
    public function IncreaseView(string $productID) : bool
    {
        return $this->CustomQuery("UPDATE product set productView = (productView + 1) WHERE productID = '$productID'");
    }

    // Check If Product Exist
    public function CheckExistProduct(string $productID) : bool
    {
        $dataFromDB = $this->SelectCondition($this->tableName, ["productID"], ["productID" => $productID]);

        if (empty($dataFromDB)) {
            return false;
        }
        return true;
    }

    // Update Status
    public function UpdateStatus(string $productID) : bool
    {
        return $this->CustomQuery("UPDATE product SET productStatus = (CASE WHEN productStatus = 0 THEN 1 ELSE 0 END) WHERE productID = '$productID'");
    }

    //Set Image For Product
    public function AddImageProduct(string $linkImg, string $productID) : bool
    {
        return $this->Update($this->tableName, ['productImg' => $linkImg], ['productID' => $productID]);
    }

    // Get Image Product
    public function GetImageProduct(string $productID) : array
    {
        return $this->SelectCondition($this->tableName, ['productImg'], ['productID' => $productID])[0];
    }
    
    // Search
    public function SearchProduct(string $keywords): array
    {
        return $this->SearchQuery("SELECT * FROM product WHERE productName LIKE '%".$keywords."%'");
    }

    public function CheckExistCatalog(string $idCatalog): string
    {
        $dataFromDB = $this->SelectCondition("product_catalog", ["catalogID", "catalogName"], ["catalogID" => $idCatalog])[0];
        if (empty($dataFromDB)) {
            return "";
        }

        return $dataFromDB['catalogName'];
    }

    public function CountProduct(): int
    {
        return $this->CountWithoutCondition($this->tableName);
    }

    public function SelectProductPage(int $start, int $end): array{
        return $this->SelectWithLimit($this->tableName, [$start => $end]);
    }
}
?>