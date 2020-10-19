<?php
//controller de salas
    namespace Controllers;

    use DAO\AuditoriumDAO as AuditoriumDAO;
    use Models\Auditorium as Auditorium;

    class AuditoriumController{

        private $auditoriumDao;

        public function __construct(){

            $this->auditoriumDao = new AuditoriumDAO();

        }
        public function showAddView (){
            require_once(VIEWS_PATH."auditorium-add.php");
        }

        public function showListView (){
            
            $cineList = $this->cineDAO->getAll();
    
            require_once(VIEWS_PATH."auditorium-list.php");
            
        }
        public function showModifyView(){
            
            require_once(VIEWS_PATH."auditorium-modify.php");
        }


        public function Add($name, $adress, $capacity, $ticketValue)
        {
            $auditorium = new Auditorium();
            $auditorium->setName($name);
            $auditorium->setCapacity($capacity);
            $auditorium->setTicketValue($ticketValue);

            $this->auditoriumDAO->Add($auditorium);

            $this->showAddView();
        }

        public function Remove($auditoriumId)
        {
            $this->auditoriumDAO->delete($auditoriumId);

            $this->showListView();
        }

        public function Modify($auditoriumId)
        {
            $auditorium= $this->auditoriumDAO->getAuditorium($auditoriumId);
            $this->auditoriumDAO->delete($auditoriumId);
            require_once(VIEWS_PATH."auditorium-modify.php");

        }

    }
    }
?>