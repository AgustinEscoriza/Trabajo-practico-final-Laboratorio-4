<?php
    namespace Controllers;

    use DAO\BillboardDAO as BillboardDAO;
    use DAO\AuditoriumDAO as AuditoriumDAO;
    use DAO\FunctionDAOMySQL as FunctionDAO;
    use Models\Billboard as Billboard;
    use DAO\MovieDAOmysql as MovieDAO;

    class BillboardController{

        private $billboardDAO;
        private $movieDAO;

        public function __construct(){

            $this->billboardDAO = new BillboardDAO();
            $this->auditoriumDAO = new AuditoriumDAO();
            $this->functionDAO = new FunctionDAO();
            $this->movieDAO = new MovieDAO();
        }


        public function ShowBillboard ($cinemaId){
            $cinemaId=$cinemaId;

            $functionsList = $this->functionDAO->getFunctionsByCinema($cinemaId);
            $moviesList = $this->MoviesInBilboard($functionsList);
            
    
            require_once(VIEWS_PATH."billboard-View.php");
            
        }

        public function MoviesInBilboard($functionsList){
            $resp = array();
            foreach($functionsList as $function)
            {
                array_push($resp,$this->movieDAO->getByMovieId($function->getMovieId())[0]);
            }            
    
            return $resp;           
        }
    }
?>