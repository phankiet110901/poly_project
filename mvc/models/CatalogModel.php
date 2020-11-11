<?php


class CatalogModel extends DBSql
{
    private $tableName = "product_catalog";

    public function GetAllCatalog()
    {
        return $this->SelectAll($this->tableName);
    }

    public function AddCatalog($dataCatalog)
    {
        return $this->Insert($this->tableName, $dataCatalog);
    }

    public function CheckExistCatalog($idCatalog)
    {
        $dataFromDB = $this->SelectCondition("product_catalog", ["catalogID"], ["catalogID" => $idCatalog]);

        if (empty($dataFromDB)) {
            return false;
        }

        return true;
    }

    public function EditCatalog($idCatalog, $dataEdit)
    {
        return $this->Update("product_catalog", $dataEdit, ["catalogID" => $idCatalog]);
    }

    public function DeleteCatalog($idCatalog)
    {
        return $this->Delete("product_catalog", ["catalogID" => $idCatalog]);
    }

}


