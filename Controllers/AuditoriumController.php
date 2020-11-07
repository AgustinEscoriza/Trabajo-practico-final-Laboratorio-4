<?php
//controller de salas
    namespace Controllers;

    use DAO\auditoriumDAOmysql as auditoriumDAOmysql;
    use DAO\FunctionDAOmysql as FunctionDAO;
    use Models\Auditorium as Auditorium;

    class AuditoriumController{

        private $auditoriumDAOmysql;
        private $functionsDAO;

        public function __construct(){

            $this->auditoriumDAOmysql = new auditoriumDAOmysql();
            $this->functionsDAO = new FunctionDAO();

        }
        public function showAddView ($cinemaId,$addMessage=""){
            require_once(VIEWS_PATH."auditorium-add.php");
        }

        public function showListView ($cinemaId){

            $auditoriumList = array();
            $auditoriumList = $this->auditoriumDAOmysql->getAuditoriumByCinemaId($cinemaId,1);


            require_once(VIEWS_PATH."auditorium-list.php");
            
        }
        public function showModifyView(){
            
            require_once(VIEWS_PATH."auditorium-modify.php");
        }   


        public function Add($name,$cinemaId, $capacity, $ticketValue)
        {

            if($this->auditoriumDAOmysql->existName($name,$cinemaId)==false){
                
                $auditorium = new Auditorium();
                $auditorium->setName($name);
                $auditorium->setCinemaId($cinemaId);
                $auditorium->setCapacity($capacity);
                $auditorium->setTicketValue($ticketValue);

                $this->auditoriumDAOmysql->Add($auditorium,$cinemaId);

                $this->showListView($cinemaId);
            }
            else{
                $this->showAddView($cinemaId,"Name already in use in this Cinema");
            }
        }



        public function ChangeAuditoriumStatus($idAuditorium)
        {
            $cinemaId = $this->auditoriumDAOmysql->getIdCinema($auditoriumId); 

            if($this->functionsDAO->CheckFunctionsStatus($idAuditorium,0))
            {
                $this->cineDAO->delete($idAuditorium);

                $this->showListView();
            }
            
            $this->showListView($cinemaId);
        }


        public function Modify($auditoriumId)
        {
            $this->auditoriumDAOmysql->modify($auditoriumId,$name,$capacity,$ticketValue);
            $this->showListView();
            
        }

    }
?>