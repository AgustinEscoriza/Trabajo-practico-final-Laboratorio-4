<?php
    namespace Controllers;

    use DAO\FunctionDAOmysql as FunctionDAOmysql;
    use DAO\AuditoriumDAOmysql as AuditoriumDAOmysql;
    use DAO\CinemaDAOmysql as CinemaDAOmysql;
    use DAO\MovieDAOmysql as MovieDAOmysql;
    use DAO\MovieDAO as MovieDAO;

    class BillboardController{

        private $functionDAO;
        private $movieDAO;
        private $cinemaDAO;

        public function __construct(){

            $this->functionDAO = new FunctionDAOmysql();
            $this->movieDAO = new MovieDAOmysql();
            $this->cinemaDAO = new CinemaDAOmysql();
        }


        public function showListView(){
            $moviesList = $this->functionDAO->getAll();

            require_once(VIEWS_PATH."billboard-View.php");
        }

    }
?>