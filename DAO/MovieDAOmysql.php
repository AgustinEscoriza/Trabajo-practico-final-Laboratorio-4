<?php
    
    namespace DAO;

    use DAO\IMovieDAO as IMovieDAO;
    use DAO\Connection as Connection;
    use DAO\QueryType as QueryType;
    use Models\Movie as Movie;
    use Models\Genre as Genre;

    class MovieDAOmysql {
        private $connection;
        private $tableName = "movies";

        public function __construct(){

            $this->connection = new Connection();
        }
        //primero comparo la lista actual con la nueva, si no hay alguna pelicula, la agrego a la base de datos, 
        //luego comparo la base de datos con la lista que baje, las q no esten entre las nuevas, se pone status 0
        public function apiToSql($movieList){
            try{
                foreach($movieList as $movie){
                    
                    $query = "INSERT INTO movies (idMovie,originalTitle,originalLanguage,overview,posterPath,releaseDate,runtime,title, movieStatus) VALUES 
                                                ( :idMovie, :originalTitle, :originalLanguage, :overview, :posterPath, :releaseDate, :runtime, :title, :movieStatus)";

                    $parameters["idMovie"] =            $movie->getId();
                    $parameters["title"] =              $movie->getTitle();
                    $parameters["originalTitle"] =      $movie->getOriginalTitle();
                    $parameters["originalLanguage"] =   $movie->getOriginalLanguage();
                    $parameters["overview"] =           $movie->getOverview();
                    $parameters["posterPath"] =         $movie->getPosterPath();
                    $parameters["releaseDate"] =        $movie->getReleaseDate();
                    $parameters["runtime"] =            $movie->getRuntime();
                    $parameters["movieStatus"] =        1;

                    $this->connection = Connection::GetInstance();

                    $this->connection->ExecuteNonQuery($query,$parameters,QueryType::StoredProcedure);
                }
            }
            catch(\PDOException $ex){
                throw $ex;
            }
        }

        public function ChangeMovieState($idMovie){
            try{
                
                    $query = "UPDATE movies set movieState = 0 where idMovie='$idMovie'";

                    //$parameters["idMovie"] = $idMovie; asi y se pasa parameters???????

                    $this->connection = Connection::GetInstance();
                
                    $result = $this->connection->Execute($query,array(),QueryType::StoredProcedure);
                
            }
            catch(\PDOException $ex){
                throw $ex;
            }
        }

        public function GetMovieByFunctionId($idFunction)
        {
            $query = "SELECT * FROM movies 
            INNER JOIN Functions 
            ON ".$this->tableName.".idMovie = Functions.idMovie 
            AND Functions.idFunction = '$idFunction'";

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query,array(),QueryType::Query);

            if(!empty($result)){
                return $this->mapear($result);
            }
            else{
                return false;
            }
        }

        public function getAll(){
            try{
                $query = "SELECT * FROM ".$this->tableName;
    
                $this->connection = Connection::GetInstance();
                
                $result = $this->connection->Execute($query,array(),QueryType::StoredProcedure);

            }
            catch(\PDOException $ex){
                throw $ex;
            }
    
            if(!empty($result)){
                return $this->mapear($result);
            }
            else{
                return false;
            }
        }

        public function getByMovieId($id){
            try{
                $query = "SELECT * FROM ".$this->tableName. " WHERE ".$this->tableName.".idMovie ='$id'";

    
                $this->connection = Connection::GetInstance();
                
                $result = $this->connection->Execute($query,array(),QueryType::StoredProcedure);
    
                
    
            }
            catch(\PDOException $ex){
                throw $ex;
            }
    
            if(!empty($result)){
                return $this->mapear($result);
            }
            else{
                return false;
            }
        }

        public function getGenresByMovieId($movieId)
        {
            try {
                $query = "SELECT genres.idGenre, genres.name FROM moviesxgenre JOIN genres ON genres.idGenre = moviesxgenre.idGenre WHERE moviesXgenre.idMovie =$movieId";
                $this->connection = Connection::GetInstance();
                $resultSet = $this->connection->Execute($query,array(),QueryType::Query);
                $genresList = array();
                foreach ($resultSet as $row) {

                    $genre = new Genre();
                    $genre->setId($row["idGenre"]);
                    $genre->setName($row["name"]);

                    array_push($genresList, $genre);
                }

                return $genresList;
            } catch (Exception $ex) {
                throw $ex;
            }
        }
        function getNowPlayingMovies(){
            $resp = file_get_contents(API_ROOT.MOVIE_PATH.MOVIE_NOW_PLAYING.API_KEY);
    
            $this->moviesToObject($resp);
    
            return $this->moviesList;
        }
    
        function moviesToObject($moviesInJSON)
        {
            $this->moviesList = array();
    
            $movies = json_decode($moviesInJSON, true);
    
            foreach($movies["results"] as $movie)
            {
                $newMovie = new Movie();
                $newMovie->setTitle($movie["title"]);
                $newMovie->setId($movie["id"]);
                foreach($movie["genre_ids"] as $genre)
                {
                    $newMovie->setGenre($genre);
                }
                $newMovie->setPosterPath($movie["poster_path"]);
                $newMovie->setOverview($movie["overview"]);
                $newMovie->setOriginalTitle($movie["original_title"]);
                $newMovie->setReleaseDate($movie["release_date"]);
                $newMovie->setOriginalLanguage($movie["original_language"]);
                $resp = $this-> getMovie($movie["id"]);
                $newMovie->setRuntime($resp["runtime"]);              
                array_push($this->moviesList,$newMovie);
            }
        }

        function getMovie($id){
            $resp = file_get_contents(API_ROOT.MOVIE_PATH.$id.API_KEY);
            
        return json_decode($resp, true);
        }

        

        protected function mapear($value) {
            $value = is_array($value) ? $value : [];
            $resp = array_map(function($p){
                $a = new Movie();
                $a->setId($p["idMovie"]);       
                $a->setTitle($p["title"]);               
                $a->setOriginalLanguage($p["originalLanguage"]); 
                $a->setOriginalTitle($p["originalTitle"]);
                $a->setOverview($p["overview"]);        
                $a->setPosterPath($p["posterPath"]);   
                $a->setReleaseDate($p["releaseDate"]);   
                $a->setRuntime($p["runtime"]);  

                return $a;
            }, $value);   // $value es cada array q quiero convertir a objeto
            return $resp;
        }
    }

?>