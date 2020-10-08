<?php
    namespace Controllers;

    use DAO\CineDAO as CineDAO;
    use Models\Cine as Cine;

    class CineController{

        private $cineDAO;

        public function __construct(){

            $this->cineDAO = new CineDAO();
        }

        public function showAddView (){
            require_once(VIEWS_PATH."cine-add.php");
        }

        public function showListView (){
            
            $cineList = $this->cineDAO->getAll();
    
            require_once(VIEWS_PATH."cine-list.php");
            
        }

        public function Add($id,$name, $adress, $capacity, $ticketValue)
        {
            $cine = new Cine();
            $cine->setId($id);
            $cine->setName($name);
            $cine->setAdress($adress);
            $cine->setCapacity($capacity);
            $cine->setTicketValue($ticketValue);

            $this->cineDAO->Add($cine);

            $this->showAddView();
        }

    }
?>