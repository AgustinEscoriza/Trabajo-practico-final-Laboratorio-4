<?php
    namespace Controllers;

    use DAO\CinemaDAOmysql as CinemaDAOmysql;
    use DAO\AuditoriumDAOmysql as AuditoriumDAO;
    use Models\Cinema as Cinema;

    class CinemaController{

        private $cinemaDAOmysql;

        public function __construct(){

            $this->cinemaDAOmysql = new CinemaDAOmysql();
            $this->auditoriumDAO = new AuditoriumDAO();
        }

        public function showAddView ($message=""){
            require_once(VIEWS_PATH."cinema-add.php");
        }

        public function showListView ($message=""){
            
            $cinemaList = $this->cinemaDAOmysql->getAll();
            $message = ($message == "") ? (empty($cinemaList)) ? " No Hay Cines Disponibles" : "" : $message;
            require_once(VIEWS_PATH."cinema-list.php");
            
        }
        public function showModifyView($cinemaId){

            $cinema = $this->cinemaDAOmysql->getCinema($cinemaId);
            require_once(VIEWS_PATH."cinema-modify.php");
        }

        public function showLoginView(){

            session_destroy();
            require_once(VIEWS_PATH."user-login.php");
        }

        public function Add($name, $adress)
        {
            $cinema = new Cinema();
            $cinema->setName($name);
            $cinema->setAdress($adress);

            $this->showAddView($this->cinemaDAOmysql->Add($cinema));;
        }

        public function ChangeCinemaStatus($idCinema)
        {
            if($this->auditoriumDAO->CheckAuditoriumStatus($idCinema))
            {
                $result = $this->cinemaDAOmysql->ChangeCinemaStatus($idCinema);

                $this->showListView(($result==1) ? "El Cine Ha Sido Eliminado Correctamente" : "Revise el Listado Por Posibles Errores de Eliminacion");
            }
            $this->showListView("El Cine no Puede Eliminarse, Ya que hay Auditoriums Activos Pertenecientes al Mismo");
        }

        public function Modify($cinemaId,$name,$adress,$message="")
        {

            $result = $this->cinemaDAOmysql->modify($cinemaId,$name,$adress);
            $message = ($result == 1) ? "El Cine Se Ha Modificado Correctamente" : "Ha Habido Errores de Edicion, Verifique la Lista";
            $this->showListView($message);
        }

        public function getCinemaList ($message=""){
            
            $cinemaList = $this->cinemaDAOmysql->getAll();
            $message = ($message == "") ? (empty($cinemaList)) ? " No Hay Cines Disponibles" : "" : $message;
            require_once(VIEWS_PATH."statistics-totalSold.php");     
        }

    }
?>