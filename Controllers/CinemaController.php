<?php
    namespace Controllers;

    use DAO\CinemaDAOmysql as CinemaDAOmysql;
    use Models\Cinema as Cinema;

    class CinemaController{

        private $cinemaDAOmysql;

        public function __construct(){

            $this->cinemaDAOmysql = new CinemaDAOmysql();
        }

        public function showAddView ($addMessage=""){
            require_once(VIEWS_PATH."cinema-add.php");
        }

        public function showListView (){
            
            $cinemaList = $this->cinemaDAOmysql->getAll();
    
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

            $this->showAddView($this->cinemaDAOmysql->Add($cinema));;
        }

        public function Remove($cinemaId)
        {
            $this->cinemaDAOmysql->delete($cinemaId);

            $this->showListView();
        }

        public function Modify($cinemaId)
        {
            $cinema = $this->cinemaDAOmysql->getCinema($cinemaId);
            $this->cinemaDAOmysql->delete($cinemaId);
            require_once(VIEWS_PATH."cinema-modify.php");

        }

    }
?>