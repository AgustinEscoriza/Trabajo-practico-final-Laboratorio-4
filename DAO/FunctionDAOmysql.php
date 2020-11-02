<?php 
    namespace DAO;

    use DAO\ICinemaDAO as ICinemaDAO;
    use DAO\Connection as Connection;
    use DAO\QueryType as QueryType;
    use Models\Functions as Functions;
    use Models\Movie as Movie;
    use DAO\MovieDAOmysql as MovieDAO;

    class FunctionDAOMySQL {
        private $movieDAO;
        private $connection;
        private $tableName = "functions";

    public function __construct(){
        $this->movieDAO = new MovieDAO();
        $this->connection = new Connection();
    }
    public function Add($cinema, $auditoriumId, Functions $newFunction){

        try{

            if (!$this->chekExistence($newFunction->getMovieId(),$newFunction->getDate())){
                $query = "INSERT INTO ".$this->tableName." ( idCinema, idAuditorium, idMovie, functionDate, functionTime) VALUES 
                                                            (:idCinema, :idAuditorium, :idMovie, :functionDate, :functionTime)";
            
                $parameters["idCinema"] = $cinema;
                $parameters["idAuditorium"] = $auditoriumId;
                $parameters["idMovie"] = $newFunction->getMovieId();
                $parameters["functionDate"] = $newFunction->getDate();
                $parameters["functionTime"] = $newFunction->getTime();

                $this->connection = Connection::GetInstance();

                $this->connection->ExecuteNonQuery($query,$parameters,QueryType::StoredProcedure);
            }
            else
            {
                echo  "<script> alert ('La Funcion que intenta agregar LA CONCHA DE TU MADRE ALL BOYS.'); </script>)";
                require_once(VIEWS_PATH."cinema-list.php");
            }
        }
        catch(\PDOException $ex){
            throw $ex;
        }
        
    }

    public function getMovies()
    {
        try {
            $movieList = array();

            $query = "SELECT movies.idMovie, movies.title, movies.posterPath, movies.releaseDate, movies.originalLanguage, movies.overview FROM movies join functions on functions.idMovie = movies.idMovie";
            $resultSet = $this->connection->execute($query,array(),QueryType::Query);

            if (!empty($resultSet)) {
                foreach ($resultSet as $row) {

                    $movie = new Movie();
                    $a->setId($p["idMovie"]);       
                    $a->setTitle($p["title"]);               
                    $a->setOriginalLanguage($p["originalLanguage"]); 
                    $a->setOverview($p["overview"]);        
                    $a->setPosterPath($p["posterPath"]);   
                    $a->setReleaseDate($p["releaseDate"]);   
                    $a->setReleaseDate($p["runtime"]);  

                    array_push($movieList, $movie);
                }
            }

            return $movieList;
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }


    
    public function chekExistence ($movieId,$date)
    {
        $flag = false;
        try{
            $query = "SELECT * FROM ".$this->tableName." WHERE ".$this->tableName.".idMovie ='$movieId'";


            $this->connection = Connection::GetInstance();
            
            $result = $this->connection->Execute($query,array(),QueryType::StoredProcedure);
        }
        catch(\PDOException $ex){
            throw $ex;
        }

        if(!empty($result)){
            $resp = $this->mapear($result);
            if($resp){
                foreach ($resp as $function) {
                    if($function->getDate() == $date){
    
                        $flag = true;  
    
                    }               
                }
            }
            return $flag; 
        }
        else
        {
            return false;
        }        
                 
    }

    public function MoviesInBilboard($functionsList){
        $resp = array();
        foreach($functionsList as $function)
        {
            array_push($resp,$this->movieDAO->getByMovieId($function->getMovieId())[0]);
        }            

        return $resp;           
    }
    public function getFunctionsByCinema($cinemaId){

        try{
            $query = "SELECT * FROM ".$this->tableName." WHERE ".$this->tableName.".idCinema ='$cinemaId'";


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

    public function getCinema($id){

        try{
            $query = "SELECT * FROM ".$this->tableName. " WHERE ".$this->tableName.".idCinema ='$id'";

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query,array(),QueryType::StoredProcedure);
        }
        catch(\PDOException $ex){
            throw $ex;
        }

        if(!empty($result)){

            return $this->mapear($result)[0];
        }
        else{
            return false;
        }
    }

    public function delete($id){ 
       
        try{
            $query = "DELETE FROM ". $this->tableName." WHERE ". $this->tableName. ".idCinema ='$id'";
            $this->connection->ExecuteNonQuery($query,QueryType::StoredProcedure);
        }
        catch(\PDOException $ex){
            throw $ex;
        }
        
    }  

    public function  modify($cinemaId,$name,$adress){

        $query = "UPDATE cinemas SET name = :name, adress = :adress WHERE idCinema = $cinemaId";
        
        $parameters['name'] = $name;
        $parameters['adress'] = $adress;

        try {

        $this->connection = Connection::getInstance();
        $this->connection->ExecuteNonQuery($query, $parameters,QueryType::StoredProcedure);

        }catch(\PDOException $ex) {

            throw $ex;
        }
    }

    protected function mapear($value) {
        $value = is_array($value) ? $value : [];
        $resp = array_map(function($p){
            $functions = new Functions();
            $functions->setDate($p['functionDate']);
            $functions->setTime($p['functionTime']);
            $functions->setMovieId($p['idMovie']);
            return $functions;
        }, $value);   // $value es cada array q quiero convertir a objeto
        return $resp;
    }
    public function getAuditorium($id){}
    public function retrieveData(){}
}

?>