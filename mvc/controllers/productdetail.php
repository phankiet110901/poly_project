<?php 
    class productdetail extends Controller{
        public function Default()
        {
            if (isset($_GET["id"]) && !empty($_GET["id"])) {
                $db = new DBSql();
                $row = $db->SelectOneCondition("product",["productID" => $_GET["id"]]);
                $listSize = $db->SelectAll("product_size");
                $this->LoadView("detailProduct",$data=[$row,$listSize]);
            }
            else
            {
                Show404Err();
            }
        }
    }
?>