<?php
    namespace Controllers;

    use DAO\MovieDAO as MovieDAO;
    use Models\Cine as Cine;
    use Models\Movie as Movie;
    use Models\Genre as Genre;
    use Models\Lenguage as Lenguage;
    use Models\ProductionCompany as ProductionCompany;
    use Models\ProductionCountry as ProductionCountry;

    class MovieController{

        private $movieDAO;

        public function __construct(){

            $this->movieDAO = new MovieDAO();
        }

        public function showMoviesListView (){
            $moviesList = $this->movieDAO->getNowPlayingMovies();
            $genresList = $this->movieDAO->getGenres();
            
            $this->setGenres($moviesList,$genresList);

            require_once(VIEWS_PATH."movies-list.php");
        }

        public function setGenres($movies,$genres){
            foreach($movies as $movie)
            {
                foreach($movie->getGenreId() as $key => $mov)
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
            $genresList = $this->movieDAO->getGenres();
            if($genreSelector!=0){                
                $moviesList = array();
                foreach($movies as $movie){
                    foreach($movie->getGenreId() as $gen){                        
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
            $this->setGenres($moviesList,$genresList);
            require_once(VIEWS_PATH."movies-list.php");             
        }
    }
?>