<?php
    
    namespace DAO;

    use DAO\Connection as Connection;
    use DAO\QueryType as QueryType;
    use Models\Genre as Genre;
    use Models\Movie as Movie;

    class GenreXMovieDAOmysql {
        private $connection;
        private $tableName = "genres";

        public function __construct(){

            $this->connection = new Connection();
        }
        public function matchMoviesWithGenre($movieList){

            try{

                    foreach($movieList as $movie){

                        $genreList=$movie->getGenre();

                        foreach($genreList as $genre){

                            $query = "INSERT INTO moviesXGenre (idMovie,idGenre) VALUES ( :idMovie, :idGenre)";

                            $parameters["idGenre"] = $genre;
                            $parameters["idMovie"] = $movie->getId();

                            $this->connection = Connection::GetInstance();

                            $this->connection->ExecuteNonQuery($query,$parameters,QueryType::StoredProcedure);
                        }

                    }
            }
            catch(\PDOException $ex){
                throw $ex;
            }
        }
    }
    

?>