<?php

class Search extends Controller
{
    // Set Default Page
    public function DefaultPage(): void
    {
        // TODO: Implement DefaultPage() method.
        $this->handleWrongUrl();
    }

    public function Searching($keywords = null) : void
    {
        // Check Empty
        if (!($keywords)) {
            $this->response(400, ['code'=>400, 'message'=>'Keywords Can Not Be Empty']);
        }

        $result = $this->LoadModel("ProductModel")->SearchProduct($keywords);

        $this->response(200, $result);
    }

}

?>