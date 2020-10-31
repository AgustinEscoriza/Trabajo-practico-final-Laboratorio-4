<?php
//controller de salas
    namespace Controllers;

    use DAO\auditoriumDAOmysql as auditoriumDAOmysql;
    use Models\Auditorium as Auditorium;

    class AuditoriumController{

        private $auditoriumDAOmysql;

        public function __construct(){

            $this->auditoriumDAOmysql = new auditoriumDAOmysql();

        }
        public function showAddView ($cinemaId){
            require_once(VIEWS_PATH."auditorium-add.php");
        }

        public function showListView ($cinemaId){

            $auditoriumList = array();
            $auditoriumList = $this->auditoriumDAOmysql->getAuditoriumByCinemaId($cinemaId);


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

            $this->auditoriumDAOmysql->Add($auditorium,$cinemaId);

            $this->showListView($cinemaId);
        }

        public function Remove($auditoriumId)
        {
            $cinemaId = $this->auditoriumDAOmysql->getIdCinema($auditoriumId); 
            $this->auditoriumDAOmysql->delete($auditoriumId);

            $this->showListView($cinemaId);
        }

        public function Modify($auditoriumId)
        {
            $this->auditoriumDAOmysql->modify($auditoriumId,$name,$capacity,$ticketValue);
            $this->showListView();
            
        }

    }
?>