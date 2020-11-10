<?php 
    class products extends Controller{
        public function Default()
        {
            $db = new DBSql();
            $list_products = $db->Select("product",["productID","productName","productPrice","productImg"]);
            $this->LoadView("allProduct",$data = $list_products);
        }
    }
?>