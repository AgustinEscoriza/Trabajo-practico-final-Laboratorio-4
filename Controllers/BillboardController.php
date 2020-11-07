<?php
    namespace Controllers;

    use DAO\BillboardDAO as BillboardDAO;
    use DAO\AuditoriumDAO as AuditoriumDAO;
    use DAO\FunctionDAOMySQL as FunctionDAO;
    use DAO\GenreDAOmysql as GenreDAO;
    use Models\Billboard as Billboard;
    use DAO\MovieDAOmysql as MovieDAO;

    class BillboardController{

        private $billboardDAO;
        private $movieDAO;

        public function __construct(){

            $this->billboardDAO = new BillboardDAO();
            $this->auditoriumDAO = new AuditoriumDAO();
            $this->functionDAO = new FunctionDAO();
            $this->genreDAO = new GenreDAO();
            $this->movieDAO = new MovieDAO();
        }


        public function ShowBillboard ($cinemaId){
            $cinemaId=$cinemaId;

            $functionsList = $this->functionDAO->getFunctionsByCinema($cinemaId,0);
            
            $moviesList = $this->MoviesInBillboard($functionsList);

            foreach($moviesList as $movie){
                $genreList= $this->movieDAO->getGenresByMovieId($movie->getId());
                foreach($genreList as $genre){
                    $movie->setGenre($genre);
                }
            }   
            
            require_once(VIEWS_PATH."billboard-View.php");
            
        }

        public function showFullList($idFunction){

                
            $functionsList = $this->functionDAO->getFunctionsByCinema(0,0);
            $genresList =   $this->genreDAO->getAll();
            $moviesList = $this->MoviesInBillboard($functionsList);
            foreach($moviesList as $movie){
                
                $genres= $this->movieDAO->getGenresByMovieId($movie->getId());
                foreach($genres as $genre){
                    $movie->setGenre($genre);
                }
            } 
            
            
            require_once(VIEWS_PATH."fullBillboard-View.php");
        }

        public function filter($genreSelector){
            $functions = $this->functionDAO->getFunctionsByCinema(0,0);
            $genresList = $this->genreDAO->getAll();  
            $moviesList = array(); 
            if($genreSelector!=0){   
                
                          
                $functionsList = array();
                foreach($functions as $function){
                    
                    $movie = $this->movieDAO->getByMovieId($function->getMovieId())[0];
                    
                    $genres= $this->movieDAO->getGenresByMovieId($movie->getId());
                    foreach($genres as $genre){

                    $movie->setGenre($genre);
                    }
                        foreach($movie->getGenre() as $gen){  
                                             
                            if($gen->getId()==$genreSelector){
                                
                                array_push($moviesList,$movie);                       
                            }
                        }
                    }
                
            }
            else
            {
                $moviesList = array();
                $functionsList = $this->functionDAO->getFunctionsByCinema(0,0);
            
                $moviesList = $this->MoviesInBillboard($functionsList);
                foreach($moviesList as $movie){
                    
                    $genres= $this->movieDAO->getGenresByMovieId($movie->getId());
                    foreach($genres as $genre){
                        $movie->setGenre($genre);
                    }
                } 
                $genreList =   $this->genreDAO->getAll();

            }        

            
            //$this->setGenres($moviesList,$genresList);
            require_once(VIEWS_PATH."fullBillboard-View.php");             
        }

        public function MoviesInBillboard($functionsList){
            $resp = array();
            foreach($functionsList as $function)
            {
                if($this->checkFunction($resp, $function->getMovieId()))
                {
                    array_push($resp,$this->movieDAO->getByMovieId($function->getMovieId())[0]);
                }               
            }               
            return $resp;           
        }

        public function checkFunction($functionsList, $idMovie)
        { 
            $resp = true;
            if(!empty($functionsList))
            {   
                foreach($functionsList as $function)
                {                    
                    if($function->getId()==$idMovie)
                    {
                        $resp = false;
                    }
                }
            }
            return $resp;
        }

       
    }
?>