<?php
    namespace Controllers;

    use DAO\BillboardDAO as BillboardDAO;
    use DAO\AuditoriumDAO as AuditoriumDAO;
    use Models\Billboard as Billboard;
    use DAO\MovieDAO as MovieDAO;

    class BillboardController{

        private $billboardDAO;
        private $movieDAO;

        public function __construct(){

            $this->billboardDAO = new BillboardDAO();
            $this->auditoriumDAO = new AuditoriumDAO();
            $this->movieDAO = new MovieDAO();
        }


        public function ShowBillboard ($cinemaId){
            $cinemaId=$cinemaId;
            $auditoriumsList = $this->auditoriumDAO->getAuditoriumbyCinemaId($cinemaId);
            $moviesList = $this->movieDAO->getNowPlayingMovies();;
            $functionsList = $this->billboardDAO->getAll();
    
            require_once(VIEWS_PATH."billboard-View.php");
            
        }
        public function showModifyView(){
            
            require_once(VIEWS_PATH."cine-modify.php");
        }

        public function showLoginView(){

            session_destroy();
            require_once(VIEWS_PATH."user-login.php");
        }

        public function Add($name, $adress)
        {
            $cine = new Cine();
            $cine->setName($name);
            $cine->setAdress($adress);

            $this->showAddView($this->cineDAO->Add($cine));;
        }

        public function Remove($cineId)
        {
            $this->cineDAO->delete($cineId);

            $this->showListView();
        }

        public function Modify($cineId)
        {
            $cine = $this->cineDAO->getCinema($cineId);
            $this->cineDAO->delete($cineId);
            require_once(VIEWS_PATH."cine-modify.php");

        }

    }
?>