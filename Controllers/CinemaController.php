<?php
    namespace Controllers;

    use DAO\CinemaDAO as CinemaDAO;
    use Models\Cinema as Cinema;

    class CinemaController{

        private $cinemaDAO;

        public function __construct(){

            $this->cinemaDAO = new CinemaDAO();
        }

        public function showAddView ($addMessage=""){
            require_once(VIEWS_PATH."cinema-add.php");
        }

        public function showListView (){
            
            $cinemaList = $this->cinemaDAO->getAll();
    
            require_once(VIEWS_PATH."cinema-list.php");
            
        }
        public function showModifyView(){
            
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

            $this->showAddView($this->cinemaDAO->Add($cinema));;
        }

        public function Remove($cinemaId)
        {
            $this->cinemaDAO->delete($cinemaId);

            $this->showListView();
        }

        public function Modify($cinemaId)
        {
            $cinema = $this->cinemaDAO->getCinema($cinemaId);
            $this->cinemaDAO->delete($cinemaId);
            require_once(VIEWS_PATH."cinema-modify.php");

        }

    }
?>