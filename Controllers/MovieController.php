<?php
    namespace Controllers;

    use DAO\MovieDAOmysql as MovieDAO;
    use DAO\GenreDAOmysql as GenreDAOmysql;
    use DAO\GenreXMovieDAOmysql as GenreXMovieDAOmysql;
    use Models\Cinema as Cinema;
    use Models\Movie as Movie;
    use Models\Genre as Genre;
    use Controllers\BillboardController as BillboardController;
    use \DateTime as NewDT;

    class MovieController{

        private $movieDAO;
        private $movieDAOmysql;
        private $genreDAOmysql;
        private $genreXMovieDAOmysql;
        private $billboardController;
        private $dateGlobal;
        public function __construct(){

            $this->movieDAO = new MovieDAO();
            $this->genreDAOmysql = new GenreDAOmysql();
            $this->genreXMovieDAOmysql = new GenreXMovieDAOmysql();
            $this->billboardController = new BillboardController();
            $this->dateGlobal = new NewDT('today');
        }

        public function cargarDatabaseMoviesGenre ($movieMessage=""){

            $moviesFromAPI = $this->movieDAO->getNowPlayingMovies();
            $genresFromAPI = $this->genreDAOmysql->getGenres();

            $moviesInDB = $this->movieDAO->getAll();
            $moviesList = $this->checkMoviesExistences($moviesInDB, $moviesFromAPI);

            $this->movieDAO->apiToSql($moviesList);
            //$this->UpdateMovieDB($moviesInDB, $moviesFromAPI); falta agregar el campo estado en la base de datos

            $genresInDB = $this->genreDAOmysql->getAll();
            $genresList = $this->checkGenresExistences($genresInDB, $genresFromAPI);

            $this->genreDAOmysql->apiToSql($genresList);
            //$this->UpdateGenresDB($genresInDB, $genresFromAPI); falta agregar el campo estado en la base de datos
                        
            $this->genreXMovieDAOmysql->matchMoviesWithGenre($moviesList);
            if(count($moviesList)==0)
            {
                $movieMessage="No Hay Nuevas Peliculas Para Mostrar";
            }
            require_once(VIEWS_PATH."movies-list.php");
        }

        public function showMoviesListView (){

            $moviesList = $this->movieDAO->getAll();

            require_once(VIEWS_PATH."movies-list.php");
        }

        public function setGenres($movies,$genres){
            foreach($movies as $movie)
            {
                foreach($movie->getGenre() as $key => $mov)
                {
                    foreach($genres as $genre)
                    {
                        if($mov==$genre->getId())
                        {
                            $movie->setGenreName($key,$genre->getName());                        
                        }
                    }
                }
            }
        }

        public function filter($genreSelector){
            
            $movies = $this->movieDAO->getNowPlayingMovies();
            $genresList = $this->genreDAOmysql->getGenres();
            if($genreSelector!=0){                
                $moviesList = array();
                foreach($movies as $movie){
                    foreach($movie->getGenre() as $gen){                        
                        if($gen==$genreSelector){
                            array_push($moviesList,$movie);                       
                        }
                    }
                }
            }
            else
            {
                $moviesList = array();
                $moviesList = $movies;
            }        
            //$this->setGenres($moviesList,$genresList);
            require_once(VIEWS_PATH."movies-list.php");             
        }

        public function checkMoviesExistences($moviesInDB, $moviesFromAPI)
        {
            $moviesList = array();

            foreach($moviesFromAPI as $movieAPI)
            {
                $existence = false;
                foreach($moviesInDB as $movieDB)
                {
                    if($movieAPI->getId()==$movieDB->getId())
                    {
                        $existence = true;
                    }
                }

                if(!$existence)
                {
                    array_push($moviesList,$movieAPI);
                }
            }       

            return $moviesList;
        }

        public function UpdateMovieDB($moviesInDB, $moviesFromAPI)
        {
            foreach($moviesInDB as $movieDB)
            {
                $existence = false;
                foreach($moviesFromAPI as $movieAPI)
                {
                    if($movieAPI->getId()==$movieDB->getId())
                    {
                        $existence = true;
                    }
                }

                if(!$existence)
                {
                    $this->ChangeMovieStatus($movieDB->getId());
                }
            }       
        }

        public function ChangeMovieStatus($idMovie)
        {
            if($this->functionsDAO->CheckFunctionsStatus($idMovie))
            {
                $this->movieDAO->ChangeMovieStatus($idMovie);
            }
            //falta setear el mensaje si no se puede eliminar
        }

        public function checkGenresExistences($genresInDB, $genresFromAPI)
        {
            $genresList = array();

            foreach($genresFromAPI as $genreAPI)
            {
                $existence = false;
                foreach($genresInDB as $genreDB)
                {
                    if($genreAPI->getId()==$genreDB->getId())
                    {
                        $existence = true;
                    }
                }

                if(!$existence)
                {
                    array_push($genresList,$genreAPI);
                }
            }       

            return $genresList;
        }

        public function UpdateGenreDB($genresInDB, $genresFromAPI)
        {
            foreach($genresInDB as $genreDB)
            {
                $existence = false;
                foreach($genresFromAPI as $genreAPI)
                {
                    if($genreAPI->getId()==$genreDB->getId())
                    {
                        $existence = true;
                    }
                }

                if(!$existence)
                {
                    $this->movieDAO->ChangeMovieState($genreDB->getId());
                }
            }       
        }

        public function getMovieList ($message=""){
            $dateFrom = $this->dateGlobal;
            $dateTo = $this->dateGlobal;
            
            $movieList = $this->movieDAOmysql->getAll();
            $message = ($message == "") ? (empty($cinemaList)) ? " No Hay Cines Disponibles" : "" : $message;
            require_once(VIEWS_PATH."statistics-totalSold.php");     
        }
    }  
?>