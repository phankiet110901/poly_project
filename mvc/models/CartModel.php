<?php

class CartModel extends DBSql{

    // Table Name
    private $tableName = "cart";
    private $subtableName = "cart_detail";

    // Get All Cart
    public function GetAllCart() : array
    {
        return $this->SelectAll($this->tableName);
    }
    
    public function GetRecentCart() : array
    {
        return $this->SearchQuery("SELECT * FROM cart WHERE `cartDate` >= CURDATE()");
    }

    public function GetOneCart(string $cartID) : array
    {
        return $this->SelectCondition($this->tableName, ['cartID', 'customerName'], ['cartID' => $cartID]);
    }

    public function GetDetailCart(string $cartID) : array
    {
        return $this->SearchQuery("SELECT cart_detail.productID, product.productName, product.productImg, cart_detail.quantity, (cart_detail.quantity * product.productPrice) AS 'totalPrice' FROM `cart_detail` INNER JOIN product ON product.productID = cart_detail.productID WHERE cart_detail.cartID = '$cartID'");
    }

    public function AddCart(array $dataCart) : bool
    {
        return $this->Insert($this->tableName, $dataCart);
    }

    public function EditCart(array $dataEdit, string $cartID) : bool
    {
        return $this->Update($this->tableName, $dataEdit, ["cartID" => $cartID]);
    }

    public function DeleteCart(string $cartID) : bool
    {
        return $this->Delete($this->tableName, ["cartID" => $cartID]);
    }

    public function DeleteCartDetail(string $cartID) : bool
    {
        return $this->Delete($this->subtableName, ["cartID" => $cartID]);
    }

    public function UpdateStatus(string $cartID) : bool
    {
        return $this->CustomQuery("UPDATE cart SET cartStatus = (CASE WHEN cartStatus = 0 THEN 1 ELSE 0 END) WHERE cartID = '$cartID'");
    }

    public function CheckCartExist(string $cartID) : bool
    {
        $res = $this->SelectCondition($this->tableName, ["cartID"], ["cartID" => $cartID]);
        if (empty($res)) {
            return false;
        }
        return true;
    }

    public function AddCartDetail(array $dataCart) : bool
    {
        return $this->Insert($this->subtableName, $dataCart);
    }
}

?>