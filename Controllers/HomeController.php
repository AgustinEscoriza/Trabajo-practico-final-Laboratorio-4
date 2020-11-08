<?php
    namespace Controllers;

    use Controllers\BillboardController as BillboardController;

    class HomeController
    {
        private $billboardController;

        public function __construct()
        {
            $this->billboardController = new BillboardController();
        }

        public function Index($message = "")
        {
            
            $this->billboardController->showFullList();
        }        
    }
?>