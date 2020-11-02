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


        public function showList(){

            $functionList = $this->functionDAO->getAll();
            $moviesList = $this->filterMovieList($this->functionDAO->getMovies());
            $genresList = $this->movieDAO->getGenreList();
            
            require_once(VIEWS_PATH . "billboard-View.php");
    
        }

        private function filterMovieList($moviesList){
            $result = array();

            foreach($moviesList as $value){
                if(!in_array($value,$result)){
                    array_push($result,$value);
                }
            }
    
            return $result;
        }

        public function getGenresByMovieId($idMovie){


            $result= $this->movieDAO->getGenresByMovieId($idMovie); 

            return $result;
        }
        public function showFilteredListGenre($genreSelector){
            
            if ($genreSelector != "") {
                $moviesList = $this->filterMovieList($this->functionDAO->getMoviesByGenre($genreSelector));
                $functionList = $this->functionDAO->getAll();
                require_once(VIEWS_PATH . "Billboard-View.php");
            } else {
                $this->showList();
            }
            //$this->setGenres($moviesList,$genresList);
            require_once(VIEWS_PATH."billboard-View.php");             
        }
    }
?>