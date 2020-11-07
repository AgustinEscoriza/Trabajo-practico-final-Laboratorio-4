<?php 
    namespace DAO;

    use DAO\ICinemaDAO as ICinemaDAO;
    use DAO\Connection as Connection;
    use DAO\QueryType as QueryType;
    use Models\Cinema as Cinema;

    class CinemaDAOmysql implements ICinemaDAO{

        private $connection;
        private $tableName = "cinemas";

    public function __construct(){

        $this->connection = new Connection();
    }
    public function Add(Cinema $cinema){

        try{
            $query = "INSERT INTO ".$this->tableName." (name, adress, cinemaStatus) 
                                                VALUES (:name, :adress, :cinemaStatus)";

        
            $parameters["name"] = $cinema->getName();
            $parameters["adress"] = $cinema->getAdress();
            $parameters["cinemaStatus"] = 1;


            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query,$parameters,QueryType::Query);
        }
        catch(\PDOException $ex){
            throw $ex;
        }
        
    }

   
    public function GetCinemaByFunctionId($idFunction)
    {
        $query = "SELECT * FROM cinemas 
        INNER JOIN Functions 
        ON ".$this->tableName.".idCinema = Functions.idCinema 
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
            
            $result = $this->connection->Execute($query,array(),QueryType::Query);

            

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

    public function ChangeCinemaStatus($idCinema){ 
       
        try{
            $query = "UPDATE ". $this->tableName." SET cinemaStatus = 0 WHERE ". $this->tableName. ".idCinema ='$idCinema'";
            $this->connection->ExecuteNonQuery($query,QueryType::Query);
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
        $this->connection->ExecuteNonQuery($query, $parameters,QueryType::Query);

        }catch(\PDOException $ex) {

            throw $ex;
        }
    }

    protected function mapear($value) {
        $value = is_array($value) ? $value : [];
        $resp = array_map(function($p){
            $a = new Cinema();
            $a->setId($p['idCinema']);
            $a->setName($p['name']);
            $a->setAdress($p['adress']);
            return $a;
        }, $value);   // $value es cada array q quiero convertir a objeto
        return $resp;
    }
    public function delete($id){}

}

?>