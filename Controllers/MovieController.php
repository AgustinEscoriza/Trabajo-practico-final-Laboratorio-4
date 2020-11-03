<?php
    namespace Controllers;

    use DAO\MovieDAOmysql as MovieDAO;
    use DAO\GenreDAOmysql as GenreDAOmysql;
    use DAO\GenreXMovieDAOmysql as GenreXMovieDAOmysql;
    use Models\Cinema as Cinema;
    use Models\Movie as Movie;
    use Models\Genre as Genre;

    class MovieController{

        private $movieDAO;
        private $movieDAOmysql;
        private $genreDAOmysql;
        private $genreXMovieDAOmysql;
        public function __construct(){

            $this->movieDAO = new MovieDAO();
            $this->genreDAOmysql = new GenreDAOmysql();
            $this->genreXMovieDAOmysql = new GenreXMovieDAOmysql();
        }

        public function cargarDatabaseMoviesGenre (){

            $moviesList = $this->movieDAO->getNowPlayingMovies();
            $genresList = $this->genreXMovieDAOmysql->getGenres();

            $this->movieDAO->apiToSql($moviesList);
            $this->genreDAOmysql->apiToSql($genresList);
            $this->genreXMovieDAOmysql->matchMoviesWithGenre($moviesList);

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
            $genresList = $this->movieDAO->getGenres();
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
    }
?>