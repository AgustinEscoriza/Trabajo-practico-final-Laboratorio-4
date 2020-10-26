<?php
//controller de salas
    namespace Controllers;

    use DAO\cinemaDAOmysql as cinemaDAOmysql;
    use Models\Auditorium as Auditorium;

    class AuditoriumController{

        private $cinemaDAOmysql;

        public function __construct(){

            $this->cinemaDAOmysql = new cinemaDAOmysql();

        }
        public function showAddView ($cinemaId){
            require_once(VIEWS_PATH."auditorium-add.php");
        }

        public function showListView ($cinemaId){


            $auditoriumList = $this->cinemaDAOmysql->getAuditoriumbyCinemaId($cinemaId);


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

            $this->cinemaDAOmysql->Add($auditorium);

            require_once(VIEWS_PATH."cinema-list.php");
        }

        public function Remove($auditoriumId)
        {
            $this->cinemaDAOmysql->delete($auditoriumId);

            require_once(VIEWS_PATH."cinema-list.php");
        }

        public function Modify($auditoriumId)
        {
            $auditorium= $this->cinemaDAOmysql->getAuditorium($auditoriumId);
            $this->cinemaDAOmysql->delete($auditoriumId);
            require_once(VIEWS_PATH."auditorium-modify.php");
            
        }

    }
?>