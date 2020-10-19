<?php
//controller de salas
    namespace Controllers;

    use DAO\AuditoriumDAO as AuditoriumDAO;
    use Models\Auditorium as Auditorium;

    class AuditoriumController{

        private $auditoriumDAO;

        public function __construct(){

            $this->auditoriumDAO = new AuditoriumDAO();

        }
        public function showAddView ($cinemaId){
            require_once(VIEWS_PATH."auditorium-add.php");
        }

        public function showListView ($cinemaId){


            $auditoriumList = $this->auditoriumDAO->getAuditoriumbyCinemaId($cinemaId);


            require_once(VIEWS_PATH."auditorium-list.php");
            
        }
        public function showModifyView(){
            
            require_once(VIEWS_PATH."auditorium-modify.php");
        }


        public function Add($name,$cinemaId, $capacity, $ticketValue)
        {
            $auditorium = new Auditorium();
            $auditorium->setName($name);
            $auditorium->setCinemaId($cinemaId);
            $auditorium->setCapacity($capacity);
            $auditorium->setTicketValue($ticketValue);

            $this->auditoriumDAO->Add($auditorium);

            require_once(VIEWS_PATH."cine-list.php");
        }

        public function Remove($auditoriumId)
        {
            $this->auditoriumDAO->delete($auditoriumId);

            require_once(VIEWS_PATH."cine-list.php");
        }

        public function Modify($auditoriumId)
        {
            $auditorium= $this->auditoriumDAO->getAuditorium($auditoriumId);
            $this->auditoriumDAO->delete($auditoriumId);
            require_once(VIEWS_PATH."auditorium-modify.php");
            
        }

    }
?>