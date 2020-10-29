<?php
    
    namespace DAO;

    use DAO\IGenreDAO as IGenreDAO;
    use DAO\Connection as Connection;
    use DAO\QueryType as QueryType;
    use Models\Genre as Genre;

    class GenreDAOmysql {
        private $connection;
        private $tableName = "genres";

        public function __construct(){

            $this->connection = new Connection();
        }
        public function apiToSql($genreList){

            try{
                foreach($genreList as $genre){
                    $query = "INSERT INTO genres (idGenre,name) VALUES ( :idGenre, :name)";

                    $parameters["idGenre"] = $genre->getId();
                    $parameters["name"] = $genre->getName();

                    $this->connection = Connection::GetInstance();

                    $this->connection->ExecuteNonQuery($query,$parameters,QueryType::StoredProcedure);
                }
            }
            catch(\PDOException $ex){
                throw $ex;
            }
        }
    protected function mapear($value) {
        $value = is_array($value) ? $value : [];
        $resp = array_map(function($p){
            $a = new Movie();
            $a->setId($p["idGenre"]);       
            $a->setName($p["name"]);        
            return $a;
        }, $value);   // $value es cada array q quiero convertir a objeto
        return $resp;
    }
}

?>