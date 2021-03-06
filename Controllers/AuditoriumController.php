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
            $cinemaId=$cinemaId;   
            require_once(VIEWS_PATH."auditorium-add.php");
        }

        public function showListView ($cinemaId,$message=""){

            $auditoriumList = array();
            $auditoriumList = $this->auditoriumDAOmysql->getAuditoriumByCinemaId($cinemaId,1);

            $message = ($message == "") ? (empty($auditoriumList)) ? " No Hay Cines Disponibles" : "" : $message;

            require_once(VIEWS_PATH."auditorium-list.php");
            
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
            $cinemaId = $this->auditoriumDAOmysql->getIdCinema($idAuditorium); 

            if($this->functionsDAO->CheckFunctionsStatus($idAuditorium,0))
            {
                $result = $this->auditoriumDAOmysql->ChangeAuditoriumStatus($idAuditorium);

                $this->showListView($cinemaId,($result==1) ? "El Auditorium Ha Sido Eliminado Correctamente" : "Revise el Listado Por Posibles Errores de Eliminacion");
            }
            //falta setear el mensaje si no se puede eliminar
            $this->showListView($cinemaId,"El Auditorium no Puede Eliminarse, Ya que hay Funciones Establecidas en Esa Sala");
        }

        public function showModifyView($idAuditorium){
            $auditorium =  $this->auditoriumDAOmysql->getAuditorium($idAuditorium)[0];
            require_once(VIEWS_PATH."auditorium-modify.php");
        }   

        public function Modify($idAuditorium, $name, $capacity, $ticketValue)
        {
            $result = $this->auditoriumDAOmysql->modify($idAuditorium,$name,$capacity,$ticketValue);
            $message = ($result == 1) ? "La Sala Se Ha Modificado Correctamente" : "Ha Habido Errores de Edicion, Verifique la Lista";
            $this->showListView($this->auditoriumDAOmysql->getIdCinema($idAuditorium), $message);           
        }

    }
?>