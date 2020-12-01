<?php
    class ProductSizeModel extends DBSql
    {
        private $tableName = "product_size";

        public function GetAllSize(): array
        {
            return $this->SelectAll($this->tableName);
        }

        public function DeleteSize($sizeID) : bool
        {
            return $this->Delete($this->tableName, ["sizeID" => $sizeID]);
        }

        public function AddSize(array $dataSize) : bool
        {
            return $this->Insert($this->tableName, $dataSize);
        }

        public function EditSize(string $sizeID, array $dataEdit) : bool
        {
            return $this->Update($this->tableName, $dataEdit, ["sizeID" => $sizeID]);
        }

        public function CheckExistSize(string $sizeID) : bool
        {
            $dataFromDB = $this->SelectCondition($this->tableName, ["sizeID"], ["sizeID" => $sizeID]);
    
            if (empty($dataFromDB)) {
                return false;
            }
    
            return true;
        }
    
    }
?>