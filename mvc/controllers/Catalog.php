<?php


class Catalog extends Controller
{

    private $listFieldName = ["catalogID", "catalogName", "catalogOrder", "catalogStatus"];

    public function DefaultPage(): void
    {
        // TODO: Implement DefaultPage() method.
        $this->handleWrongUrl();
    }

    public function GetAllCatalog(): void
    {
        $this->response(200, $this->LoadModel("CatalogModel")->GetAllCatalog());
    }

    public function AddCatalog(): void
    {

        // method not allow
        $this->handleWrongMethod("POST");

        $this->HandleTokenValidate();


        $listFieldForAdd = [$this->listFieldName[1]];
        $fieldId = $this->listFieldName[0]; // get id field


        // read data in body request
        $bodyContent = $this->GetDataFromBody();

        $this->ValidDataFromRequest([$this->listFieldName[1]], $bodyContent);


        // insert data in database
        $dataInsert[$fieldId] = genUUIDV4(); // create id

        // set data
        foreach ($listFieldForAdd as $tableName) {
            $dataInsert[$tableName] = $bodyContent[$tableName];
        }

        if ($this->LoadModel("CatalogModel")->AddCatalog($dataInsert)) {
            $this->response(201);
        } else {
            $this->response(400, ['code' => 400, "message" => "Data Invalid"]);
        }

    }

    public function EditCatalog(string $idCatalog = null): void
    {
        $this->handleWrongMethod("PUT");


        $this->HandleTokenValidate();

        if (!$idCatalog) {
            $this->response(400, ["code" => 400, "message" => 'ID Can Not Empty']);
        }

        $res = $this->LoadModel("CatalogModel")->CheckExistCatalog($idCatalog);

        if (!$res) {
            $this->response(400, ["code" => 400, "message" => "ID Invalid"]);
        }

        $dataPut = $this->GetDataFromBody();

        $this->ValidDataFromRequest([$this->listFieldName[1]], $dataPut);

        if ($this->LoadModel("CatalogModel")->EditCatalog($idCatalog, $dataPut)) {
            $this->response(200, $dataPut);
        } else {
            $this->response(400, ["code" => 400, "message" => "Data Invalid"]);
        }

    }

    public function DeleteCatalog(string $idCatalog = null): void
    {
        $this->handleWrongMethod("DELETE");

        $this->HandleTokenValidate();

        // check param id
        if (!$idCatalog) {
            $this->response(400, ["code" => 400, "message" => "ID Can Not Empty"]);
        }

        // check auth catalog
        if (!$this->LoadModel("CatalogModel")->CheckExistCatalog($idCatalog)) {
            $this->response(400, ["code" => 400, "message" => "ID InValid"]);
        }

        // delete data
        if ($this->LoadModel("CatalogModel")->DeleteCatalog($idCatalog)) {
            $this->response(201);
        } else {
            $this->response(500);
        }

    }

    public function ChangeStatusCatalog(string $idCatalog = null): void
    {
        $this->handleWrongMethod("PUT");
        $this->HandleTokenValidate();

        if (!$idCatalog) {
            $this->response(400);
        }

        if (!$this->Auth('product_catalog', [$this->listFieldName[0] => $idCatalog])) {
            $this->response(400, ['code' => 400, 'message' => 'Invalid Id Catalog']);
        }

        $currentStatus = $this->LoadModel("CatalogModel")->GetCurrentStatusCatalog($idCatalog);

        if (!$this->LoadModel("CatalogModel")->UpdateStatusCatalog($idCatalog, !$currentStatus)) {
            $this->response(500);
        }

        $this->response(200);
    }

    public function ChangeOrderCatalog(string $idCatalog, int $newOrderCatalog): void
    {
        $res = $this->LoadModel("CatalogModel")->GetInfoCatalogEditOrder($idCatalog, $newOrderCatalog);

        if(!$res){
            $this->response(500);
        }
        $this->response(200);

    }
}


