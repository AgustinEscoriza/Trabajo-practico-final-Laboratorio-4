<?php 
    namespace DAO;

    use DAO\ICinemaDAO as ICinemaDAO;
    use DAO\Connection as Connection;
    use DAO\QueryType as QueryType;
    use Models\Functions as Functions;
    use Models\Movie as Movie;
    use DAO\MovieDAOmysql as MovieDAO;
    use \DateTime as NewDT;
    

    class FunctionDAOMySQL implements IFunctionDAO{
        private $movieDAO;
        private $connection;
        private $tableName = "Functions";
        private $functionMessage;
        private $date;

    public function __construct(){
        $this->movieDAO = new MovieDAO();
        $this->connection = new Connection();
        $this->date = new NewDT('today');
        $this->functionMessage ="";
    }
    public function Add($cinema, $auditoriumId, Functions $newFunction)
    {
        try
        {
            $this->functionMessage ="";
            

           
                $query = "INSERT INTO ".$this->tableName." ( idCinema, idAuditorium, idMovie, functionDate, functionTime, functionStatus) VALUES 
                                                            (:idCinema, :idAuditorium, :idMovie, :functionDate, :functionTime, :functionStatus)";
            
                $parameters["idCinema"] = $cinema;
                $parameters["idAuditorium"] = $auditoriumId;
                $parameters["idMovie"] = $newFunction->getMovieId();
                $parameters["functionDate"] = $newFunction->getDate();
                $parameters["functionTime"] = $newFunction->getTime();
                $parameters["functionStatus"] = 1;

                $this->connection = Connection::GetInstance();

                $this->connection->ExecuteNonQuery($query,$parameters,QueryType::StoredProcedure);

                $this->functionMessage ="Funcion Agregada Con Exito!";
                return true;            
        }
        catch(\PDOException $ex){
            throw $ex;
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

    public function getByFunctionId($idFunction)
    {
        try{
        $query = "SELECT * FROM Functions WHERE idFunction = '$idFunction'";

        $this->connection = Connection::GetInstance();

        $result = $this->connection->Execute($query,array(),QueryType::Query);
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

    public function ChangeFunctionsStatus($idFunction)
    {
        try
        {            
                $query = "UPDATE Functions set functionStatus = 0 WHERE idFunction='$idFunction'";

                $this->connection = Connection::GetInstance();
            
                return $this->connection->ExecuteNonQuery($query,array(),QueryType::StoredProcedure);
        }
        catch(\PDOException $ex){
            throw $ex;
        }
    }
    
    public function CheckFunctionsStatus($idAuditorium,$idMovie)
    {
        $status = false;

        $functionsList = ($idAuditorium !=0) ? $this->GetFunctionsByAuditoriumId($idAuditorium,"") 
                                              :$this->GetFunctionsByMovieId($idMovie);

        if(empty($functionsList))
        {
            $status = true;
        }

        return $status;
    }
    
    public function GetFunctionsByAuditoriumId($idAuditorium,$dateFunction)
    {
        try{

        $today = $this->date->format('Y-m-d');
        $query = ($dateFunction == "" ) ? "SELECT * FROM ".$this->tableName." 
                WHERE ".$this->tableName.".functionDate > '$today' and ".$this->tableName.".idAuditorium ='$idAuditorium'":
                "SELECT * FROM ".$this->tableName." 
                WHERE ".$this->tableName.".functionDate = '$dateFunction' and ".$this->tableName.".idAuditorium ='$idAuditorium'";
    
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

    public function SearchFunctionsFromTo($dateFrom,$dateTo,$idCinema)
    {
        try{

            $query = ($idCinema == 0) ? "SELECT * FROM ".$this->tableName." 
                    WHERE ".$this->tableName.".functionDate >= '$dateFrom' and ".$this->tableName.".functionDate <= '$dateTo'"
                                    :"SELECT * FROM ".$this->tableName." 
                                    WHERE ".$this->tableName.".functionDate >= '$dateFrom' and ".$this->tableName.".functionDate <= '$dateTo' 
                                    and ".$this->tableName.".idCinema = '$idCinema'";

        
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

    public function GetFunctionsByMovieId($idMovie)
    {
        try{
        $query = "SELECT * FROM ".$this->tableName." WHERE ".$this->tableName.".idMovie ='$idMovie' 
                                                    and ".$this->tableName.".functionStatus = 1" ;

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

    public function getFunctionsByCinema($cinemaId,$idMovie){

        try{
            $today = $this->date->format('Y-m-d');
 
            if($cinemaId==0)
            {
                $query = ($idMovie==0) ? "SELECT * FROM ".$this->tableName." WHERE ".$this->tableName.".functionDate >='$today'" :
                                         "SELECT * FROM ".$this->tableName." WHERE ".$this->tableName.".idMovie ='$idMovie' 
                                         and ".$this->tableName.".functionDate >='$today'";
            }
            else
            {
                $query = ($idMovie==0) ? "SELECT * FROM ".$this->tableName." WHERE ".$this->tableName.".idCinema ='$cinemaId'" :
                                        "SELECT * FROM ".$this->tableName." WHERE ".$this->tableName.".idCinema ='$cinemaId' 
                                        and ".$this->tableName.".idMovie ='$idMovie' and ".$this->tableName.".functionDate >='$today'";
            }
            


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
            $today = $this->date->format('Y-m-d');
            $query = "SELECT * FROM ".$this->tableName." WHERE ".$this->tableName.".functionDate > '$today'";

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
    /*public function getMovies()
    {
        try {
            $movieList = array();

            $query = "SELECT distinct(movies.idMovie), movies.originalTitle, movies.originalLanguage, movies.posterPath, movies.releaseDate, movies.runtime, movies.title, movies.overview FROM movies join functions on functions.idMovie = movies.idMovie";
            $resultSet = $this->connection->execute($query,array(),QueryType::Query);

            if (!empty($resultSet)) {
                foreach ($resultSet as $row) {

                    $movie = new Movie();
                    $movie->setId($row["idMovie"]);
                    $movie->setTitle($row["title"]);
                    $movie->setPosterPath($row["posterPath"]);
                    $movie->setReleaseDate($row["releaseDate"]);
                    $movie->setOriginalLanguage($row["originalLanguage"]);
                    $movie->setOriginalTitle($row["originalTitle"]);
                    $movie->setOverview($row["overview"]);
                    $movie->setRuntime($row["runtime"]);

                    array_push($movieList, $movie);
                }
            }

            return $movieList;
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }*/

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
            $functions->setId($p['idFunction']);
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