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
        private $billboardController;
        private $functionMessage;
        private $date;

    public function __construct(){
        $this->movieDAO = new MovieDAO();
        $this->connection = new Connection();
        $this->date = new NewDT('today');
        $this->functionMessage ="";
    }
    public function Add($cinema, $auditoriumId, Functions $newFunction){

        try{
            $this->functionMessage ="";
            $resp = $this->movieDAO->getMovie($newFunction->getMovieId());
                    $runtime = $resp["runtime"];

            if ((!$this->chekExistence($newFunction->getMovieId(),$newFunction->getDate()))&&
                (!$this->checkDate($auditoriumId,$newFunction->getDate(), $newFunction->getTime(),$runtime))){
                $query = "INSERT INTO ".$this->tableName." ( idCinema, idAuditorium, idMovie, functionDate, functionTime) VALUES 
                                                            (:idCinema, :idAuditorium, :idMovie, :functionDate, :functionTime)";
            
                $parameters["idCinema"] = $cinema;
                $parameters["idAuditorium"] = $auditoriumId;
                $parameters["idMovie"] = $newFunction->getMovieId();
                $parameters["functionDate"] = $newFunction->getDate();
                $parameters["functionTime"] = $newFunction->getTime();

                $this->connection = Connection::GetInstance();

                $this->connection->ExecuteNonQuery($query,$parameters,QueryType::StoredProcedure);

                $this->functionMessage ="Funcion Agregada Con Exito!";
                return true;
            }
            else
            {
                return false;                
            }
        }
        catch(\PDOException $ex){
            throw $ex;
        }
        
    }

    public function checkDate($idAuditorium,$date, $time, $newFunctionRuntime)
    {
        $flag = false;
        try{
            $query = "SELECT * FROM ".$this->tableName." WHERE ".$this->tableName.".functionDate = '$date' and ".$this->tableName.".idAuditorium ='$idAuditorium'";

            $this->connection = Connection::GetInstance();
            
            $result = $this->connection->Execute($query,array(),QueryType::StoredProcedure);
        }
        catch(\PDOException $ex)
        {
            throw $ex;
        }
        if(!empty($result)){
            $resp = $this->mapear($result);
            if($resp){        
                //Seteo el tiempo de inicio de la Nueva Funcion X2 para tomar inicio y final        
                $newFunctionTimeStart = new NewDT($time);
                $newFunctionTimeEnd = new NewDT($time);

                //agrego la duracion de la nueva funcion a la variable End
                $newFunctionTimeEnd->modify('+'.$newFunctionRuntime.' minutes');

                //convierto las variables a string para trabajarlas
                $newFunctionTimeStartConvert = strtotime($newFunctionTimeStart->format("H:i:s"));
                $newFunctionTimeEndConvert = strtotime($newFunctionTimeEnd->format("H:i:s"));

                //realizo el calculo de horas mas minutos para trabajar la comparacion como un entero
                $newFunctionTimeStartInt =(((idate('H',$newFunctionTimeStartConvert)) * 60) + idate('i',$newFunctionTimeStartConvert));
                $newFunctionTimeEndInt =(((idate('H',$newFunctionTimeEndConvert)) * 60) + idate('i',$newFunctionTimeEndConvert) + 15);
                foreach ($resp as $function) {
                    //Traigo el Objeto Movie con el ID, para extraer la duracion de la funcion
                    $respFunction = $this->movieDAO->getMovie($function->getMovieId());
                    $runtime = $respFunction["runtime"];
                    $endFunction =  new NewDT ($function->getTime());
                    $startFunction =  new NewDT ($function->getTime());                    
                    $endFunction->modify('+'.$runtime.' minutes');
                    

                    $startFunctionConvert = strtotime($startFunction->format("H:i:s"));
                    $endFunctionConvert = strtotime($endFunction->format("H:i:s"));
                    

                    $startFunctionInt = (((idate('H',$startFunctionConvert)) * 60) + idate('i',$startFunctionConvert));
                    $endFunctionInt =(((idate('H',$endFunctionConvert)) * 60) + idate('i',$endFunctionConvert) + 15);

                    
                    if((($startFunctionInt < $newFunctionTimeStartInt) && ($newFunctionTimeStartInt < $endFunctionInt))
                    || (($newFunctionTimeStartInt < $startFunctionInt) && ($startFunctionInt < $newFunctionTimeEndInt))){    
                        $flag = true; 
                        $this->functionMessage ="El Horario No Puede Ser Seleccionado Ya Que No Respeta las Reglas de Horarios de Funciones";
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
                        $this->functionMessage ="La Pelicula Que Desea Agregar Ya Sera Reproducida En Otro Cine En La Fecha Seleccionada";
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

    public function getByFunctionId($idFunction)
    {
        $query = "SELECT * FROM Functions WHERE idFunction = '$idFunction'";

        $this->connection = Connection::GetInstance();

        $result = $this->connection->Execute($query,array(),QueryType::Query);

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
    public function getMovies()
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