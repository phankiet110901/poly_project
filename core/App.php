<?php 

class App{
    
    protected $controller;
    protected $action;
    protected $param;

    protected $controllerUrl = "mvc/controllers/";


    function __construct($defaultController, $defaultAction, $defaultParam){

        // gan cac tham so mac dinh
        $this->controller = $defaultController;
        if($defaultAction == ""){
            $this->action = "Default";
        }else{
            $this->action = $defaultAction;
        }
        $this->param = $defaultParam;

        $dataUrl = $this->UrlProcess();

        //print_r($dataUrl);

        // Xu li controller

        // kiem tra controller co ton tai hay khong 
        if(!empty($dataUrl[0])){
            if(file_exists($this->controllerUrl.$dataUrl[0].".php") ){
                $this->controller = $dataUrl[0];
                unset($dataUrl[0]);
            }else{
                // kiem tra default controller co ton tai hay khong 
               if(file_exists($this->controllerUrl.$defaultController.".php") ){
                    $this->controller = $defaultController;
               }else{
                   Show404Err();
               }
            }
        }
        require_once $this->controllerUrl.$this->controller.".php";
        $this->controller = new $this->controller; // khoi tao doi tuong controller
        // Xu li action
        if(isset($dataUrl[1]) ){
            // kiem tra action co ton tai hay khong 
            if(method_exists( $this->controller, $dataUrl[1] )){
                $this->action = $dataUrl[1];
            }
            unset($dataUrl[1]); 
        }


       // Xu li param

       if($dataUrl){
            $this->param = array_values($dataUrl);
       }

       // chay ham action trong file controller voi tham so la param
       call_user_func_array([$this->controller,$this->action],$this->param);


        // echo "<br/> Controller ". $this->controller ."<br/>";
        // echo " Action ". $this->action  ."<br/>";
        // print_r($this->param);

    }

    function UrlProcess(){
        // kiem tra url co duoc nhap day du hay khong
        if(isset($_GET["url"]) ){
           $url = filter_var(trim($_GET["url"])); // lam sach url
           return explode("/",filter_var(trim($_GET["url"]))); // tach gia tri
        }
    }

}





?>