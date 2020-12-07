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
        $keywords = trim($keywords);

        $result = $this->LoadModel("ProductModel")->SearchProduct($keywords);

        $this->response(200, $result);
    }

}

?>