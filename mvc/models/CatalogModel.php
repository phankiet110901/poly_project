<?php


class CatalogModel extends DBSql
{
    private $tableName = "product_catalog";

    public function GetAllCatalog() : array
    {
        return $this->SelectAll($this->tableName);
    }

    public function AddCatalog(array $dataCatalog) : bool
    {
        return $this->Insert($this->tableName, $dataCatalog);
    }

    public function CheckExistCatalog(string $idCatalog) : bool
    {
        $dataFromDB = $this->SelectCondition("product_catalog", ["catalogID"], ["catalogID" => $idCatalog]);

        if (empty($dataFromDB)) {
            return false;
        }

        return true;
    }

    public function EditCatalog(string $idCatalog, array $dataEdit) : bool
    {
        return $this->Update("product_catalog", $dataEdit, ["catalogID" => $idCatalog]);
    }

    public function DeleteCatalog(string $idCatalog) : bool
    {
        return $this->Delete("product_catalog", ["catalogID" => $idCatalog]);
    }

}


