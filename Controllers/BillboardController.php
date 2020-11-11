<?php
    namespace Controllers;

    use DAO\BillboardDAO as BillboardDAO;
    use DAO\AuditoriumDAO as AuditoriumDAO;
    use DAO\FunctionDAOMySQL as FunctionDAO;
    use DAO\GenreDAOmysql as GenreDAO;
    use Models\Billboard as Billboard;
    use DAO\MovieDAOmysql as MovieDAO;
    use DAO\CinemaDAOmysql as CinemaDAO;
    use \DateTime as NewDT;

    class BillboardController{

        private $billboardDAO;
        private $auditoriumDAO;
        private $functionDAO;
        private $genreDAO;
        private $movieDAO;
        private $cinemaDAO;
        private $dateGlobal;


        public function __construct(){

            $this->billboardDAO = new BillboardDAO();
            $this->auditoriumDAO = new AuditoriumDAO();
            $this->functionDAO = new FunctionDAO();
            $this->genreDAO = new GenreDAO();
            $this->movieDAO = new MovieDAO();
            $this->cinemaDAO = new CinemaDAO();
            $this->dateGlobal = new NewDT('today');
        }


        public function ShowBillboard ($cinemaId, $message=""){
            $dateFrom = $this->dateGlobal;
            $dateTo = $this->dateGlobal;
            $cinema = $this->cinemaDAO->getCinema($cinemaId);
            $genresList =   $this->genreDAO->getAll();
            $functionsList = $this->functionDAO->getFunctionsByCinema($cinemaId,0);
            
            $moviesList = $this->MoviesInBillboard($functionsList);

            foreach($moviesList as $movie){
                $genreList= $this->movieDAO->getGenresByMovieId($movie->getId());
                foreach($genreList as $genre){
                    $movie->setGenre($genre);
                }
            }   
            $message = ($message == "") ? (empty($moviesList)) ? " No Hay Funciones Disponibles" : "" : $message;
            
            require_once(VIEWS_PATH."billboard-View.php");
            
        }

        public function HomePage()
        {
            $functionsList = $this->functionDAO->getAll();
            $genresList =   $this->genreDAO->getAll();
            $moviesList = $this->MoviesInBillboard($functionsList);
            $this->showFullList();
        }

        public function showFullList($message="")
        {

            $dateFrom = $this->dateGlobal;
            $dateTo = $this->dateGlobal;
            $functionsList = $this->functionDAO->getAll();
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

        public function filter($cinemaId,$genreSelector,$message="")
        {
            $dateFrom = $this->dateGlobal;
            $dateTo = $this->dateGlobal;
            $functions = $this->functionDAO->getFunctionsByCinema($cinemaId,0);
            $genresList = $this->genreDAO->getAll();  
            $moviesList = array(); 
            if($genreSelector!=0){   
                                         
                $functionsList = array();
                foreach($functions as $function){
                    
                    $movie = $this->movieDAO->getByMovieId($function->getMovieId());
                    
                    $genres= $this->movieDAO->getGenresByMovieId($movie->getId());
                    foreach($genres as $genre){

                    $movie->setGenre($genre);
                    }
                        foreach($movie->getGenre() as $gen){  
                                             
                            if(($gen->getId()==$genreSelector) && ($this->checkMovie($moviesList, $movie->getId())) ){
                                
                                array_push($moviesList,$movie);                       
                            }
                        }
                    }
                
            }
            else
            {
                $moviesList = array();
                $functionsList = $this->functionDAO->getFunctionsByCinema($cinemaId,0);
            
                $moviesList = $this->MoviesInBillboard($functionsList);
                foreach($moviesList as $movie){
                    
                    $genres= $this->movieDAO->getGenresByMovieId($movie->getId());
                    foreach($genres as $genre){
                        $movie->setGenre($genre);
                    }
                } 
                $genreList =   $this->genreDAO->getAll();

            }    
            $message = (empty($moviesList)) ? "No Hay Funciones Para el Criterio Seleccionado" : "" ;    
            if($cinemaId==0)
            {
                require_once(VIEWS_PATH."fullBillboard-View.php");
            }
            else
            {
                $cinema= $this->cinemaDAO->getCinema($cinemaId);
                require_once(VIEWS_PATH."billboard-View.php");
            }            
        }

        public function DateFilter($dateFrom, $dateTo, $cinemaId=0, $message="")
        {        
                  
            $functionsList = $this->functionDAO->SearchFunctionsFromTo($dateFrom,$dateTo,$cinemaId);
            $genresList =   $this->genreDAO->getAll();
            $moviesList = $this->MoviesInBillboard($functionsList);
            foreach($moviesList as $movie){
                
                $genres= $this->movieDAO->getGenresByMovieId($movie->getId());
                foreach($genres as $genre){
                    $movie->setGenre($genre);
                }
            } 
            
            $message = (empty($moviesList)) ? "No Hay Funciones Para el Criterio Seleccionado" : "" ;
            $dateFrom = $this->dateGlobal;
            $dateTo = $this->dateGlobal; 
            if($cinemaId==0)
            {
                require_once(VIEWS_PATH."fullBillboard-View.php");
            }
            else
            {
                $cinema= $this->cinemaDAO->getCinema($cinemaId);
                require_once(VIEWS_PATH."billboard-View.php");
            }
            
        }

        public function MoviesInBillboard($functionsList){
            $resp = array();
            if(!empty($functionsList)){
                foreach($functionsList as $function)
                {
                    if($this->checkFunction($resp, $function->getMovieId()))
                    {
                        array_push($resp,$this->movieDAO->getByMovieId($function->getMovieId()));
                    }               
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

        public function checkMovie($moviesList, $idMovie)
        { 
            $resp = true;
            if(!empty($moviesList))
            {   
                foreach($moviesList as $movie)
                {                
                    if($movie->getId()==$idMovie)
                    {
                        $resp = false;
                    }
                }
            }
            return $resp;
        }

       
    }
?>