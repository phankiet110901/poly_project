<?php


class Catalog extends Controller
{
    private $listTableName = ["catalogID", "catalogName", "catalogOrder", "catalogStatus"];

    public function DefaultPage()
    {
        // TODO: Implement DefaultPage() method.
        $this->response(400, ["code" => 400, "message" => "Invalid URL"]);
    }

    public function GetAllCatalog()
    {
        $this->response(200, $this->LoadModel("CatalogModel")->GetAllCatalog());
    }

    public function AddCatalog()
    {

        // method not allow
        if ($this->getRequestType() !== "POST") {
            $this->response(405);
        }

        // remove catalogID field
        $listTableForAdd = array_slice($this->listTableName, 1);
        $fieldId = $this->listTableName[0]; // get id field

        // remove catalogOrder field
        array_splice($listTableForAdd, 1, 1);

        // read data in body request
        $bodyContent = $this->GetDataFromBody();

        $this->ValidDataFromRequest($listTableForAdd, $bodyContent);


        // insert data in database
        $dataInsert[$fieldId] = genUUIDV4(); // create id

        // set data
        foreach ($listTableForAdd as $tableName) {
            $dataInsert[$tableName] = $bodyContent[$tableName];
        }

        if ($this->LoadModel("CatalogModel")->AddCatalog($dataInsert)) {
            $this->response(201);
        } else {
            $this->response(400, ['code' => 400, "message" => "Data Invalid"]);
        }

    }

    public function EditCatalog($idCatalog = null)
    {
        if ($this->getRequestType() != "PUT") {
            $this->response(405);
        }

        if (!$idCatalog) {
            $this->response(400, ["code" => 400, "message" => 'ID Can Not Empty']);
        }

        $res = $this->LoadModel("CatalogModel")->CheckExistCatalog($idCatalog);

        if (!$res) {
            $this->response(400, ["code" => 400, "message" => "ID Invalid"]);
        }

        $dataPut = $this->GetDataFromBody();

        $this->ValidDataFromRequest([$this->listTableName[1], $this->listTableName[3]], $dataPut);

        if ($this->LoadModel("CatalogModel")->EditCatalog($idCatalog, $dataPut)) {
            $this->response(200, $dataPut);
        } else {
            $this->response(400, ["code" => 400, "message" => "Data Invalid"]);
        }

    }

    public function DeleteCatalog($idCatalog = null)
    {
        // check type request
        if ($this->getRequestType() != "DELETE") {
            $this->response(405);
        }

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
}


