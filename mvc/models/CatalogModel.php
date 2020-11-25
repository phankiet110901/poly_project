<?php


class CatalogModel extends DBSql
{
    private $tableName = "product_catalog";

    public function GetAllCatalog(): array
    {
        return $this->SelectAll($this->tableName);
    }

    public function AddCatalog(array $dataCatalog): bool
    {
        return $this->Insert($this->tableName, $dataCatalog);
    }

    public function CheckExistCatalog(string $idCatalog): bool
    {
        $dataFromDB = $this->SelectCondition("product_catalog", ["catalogID"], ["catalogID" => $idCatalog]);

        if (empty($dataFromDB)) {
            return false;
        }

        return true;
    }

    public function EditCatalog(string $idCatalog, array $dataEdit): bool
    {
        return $this->Update("product_catalog", $dataEdit, ["catalogID" => $idCatalog]);
    }

    public function DeleteCatalog(string $idCatalog): bool
    {
        return $this->Delete("product_catalog", ["catalogID" => $idCatalog]);
    }

    public function GetCurrentStatusCatalog(string $idCatalog): bool
    {
        return $this->SelectCondition('product_catalog', ['catalogStatus'], ['catalogID' => $idCatalog])[0]['catalogStatus'];
    }

    public function UpdateStatusCatalog(string $idCatalog, bool $newStatus): bool
    {
        return $this->Update($this->tableName, ['catalogStatus' => $newStatus], ['catalogID' => $idCatalog]);
    }

    public function GetInfoCatalogEditOrder(string $idCatalog, int $valueChange): bool
    {
        $fistCatalog = $this->SelectCondition($this->tableName, ['catalogID', 'catalogOrder'], ['catalogID' => $idCatalog])[0];
        $secondCatalog = $this->SelectCondition($this->tableName, ['catalogID', 'catalogOrder'], ['catalogOrder' => $valueChange])[0];

        if (empty($fistCatalog) || empty($secondCatalog)) {
            return false;
        }

        $resSetTempVal = $this->Update('product_catalog', ['catalogOrder' => -1], ['catalogOrder' => $valueChange]);
        if(!$resSetTempVal){
            return false;
        }

        $firstCatalogOrderVal = $fistCatalog['catalogOrder'];
        $resNewValueForFirstCatalog = $this->Update('product_catalog',['catalogOrder' => $valueChange],['catalogID' => $fistCatalog['catalogID']]);

        if(!$resNewValueForFirstCatalog) {
            return false;
        }

        $resNewValueForSecondCatalog = $this->Update('product_catalog',['catalogOrder' => $firstCatalogOrderVal], ['catalogID' => $secondCatalog['catalogID']]);

        if(!$resNewValueForSecondCatalog) {
            return false;
        }

        return true;
    }
}


