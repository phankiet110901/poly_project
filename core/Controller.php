<?php 

abstract class Controller{
    private $modelUrl = "./mvc/models/";
    private $viewUrl = "./mvc/views/";

    public function LoadModel($modelName){
        // kiem tra model co ton tai hay khong
        if(file_exists($this->modelUrl.$modelName.".php")){
            require_once $this->modelUrl.$modelName.".php";
            return new $modelName;
        }
    }

    public function LoadView($viewName,$data=[]){
        // kiem tra view co ton tai hay khong
        if(file_exists($this->viewUrl.$viewName.".php")){
            require_once $this->viewUrl.$viewName.".php";
            //return new $viewName;
        }
    }

    abstract public function Default();

}


?>