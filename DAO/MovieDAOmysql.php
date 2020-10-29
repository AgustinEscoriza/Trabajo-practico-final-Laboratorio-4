<?php
    
    namespace DAO;

    use DAO\IMovieDAO as IMovieDAO;
    use DAO\Connection as Connection;
    use DAO\QueryType as QueryType;
    use Models\Movie as Movie;

    class MovieDAOmysql {
        private $connection;
        private $tableName = "movies";

        public function __construct(){

            $this->connection = new Connection();
        }
        
        public function apiToSql($movieList){
            try{
                foreach($movieList as $movie){
                    
                    $query = "INSERT INTO movies (idMovie,adult,budget,originalLanguage,originalTitle,overview,popularity,posterPath,releaseDate,runtime,status,title) VALUES ( :idMovie, :adult, :budget, :originalLanguage, :originalTitle, :overview, :popularity, :posterPath, :releaseDate, :runtime, :status, :title)";

                    $parameters["idMovie"] =            $movie->getId();
                    $parameters["title"] =              $movie->getTitle();
                    $parameters["adult"] =              $movie->getAdult();
                    $parameters["budget"] =             $movie->getBudget();
                    $parameters["genre"] =              $movie->getGenre();
                    $parameters["originalLanguage"] =   $movie->getOriginalLanguage();
                    $parameters["originalTitle"] =      $movie->getOriginalTitle();
                    $parameters["overview"] =           $movie->getOverview();
                    $parameters["popularity"] =         $movie->getPopularity();
                    $parameters["posterPath"] =         $movie->getPosterPath();
                    $parameters["releaseDate"] =        $movie->getReleaseDate();
                    $parameters["runtime"] =            $movie->getRuntime();
                    $parameters["status"] =             $movie->getStatus();

                    $this->connection = Connection::GetInstance();

                    $this->connection->ExecuteNonQuery($query,$parameters,QueryType::StoredProcedure);
                }
            }
            catch(\PDOException $ex){
                throw $ex;
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
                $query = "SELECT * FROM cinemas WHERE idMovie = $id";
    
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
        protected function mapear($value) {
            $value = is_array($value) ? $value : [];
            $resp = array_map(function($p){
                $a = new Movie();
                $a->setId($p["idMovie"]);       
                $a->setTitle($p["title"]);        
                $a->setAdult($p["adult"]);         
                $a->setBudget($p["budget"]);        
                $a->setGenre($p["genre"]);       
                $a->setOriginalLanguage($p["originalLanguage"]); 
                $a->setOriginalTitle($p["originalTitle"]);
                $a->setOverview($p["overview"]);    
                $a->setPopularity($p["popularity"]);    
                $a->setPosterPath($p["posterPath"]);   
                $a->setReleaseDate($p["releaseDate"]);   
                $a->setRuntime($p["runtime"]);      
                $a->setStatus($p["status"]);
                return $a;
            }, $value);   // $value es cada array q quiero convertir a objeto
            return $resp;
        }
    }

?>