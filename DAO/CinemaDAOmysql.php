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
            $query = "INSERT INTO ". $this->tableName. "(name,price,capacity) VALUES (:name, :price, :capacity)";

            $parameters["name"] = $cinema->getName();
            $parameters["adress"] = $cinema->getAdress();

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query,$parameters,QueryType::StoredProcedure);
        }
        catch(\PDOException $ex){
            throw $ex;
        }
        
    }
    public function getAll(){

        try{
            $query = "SELECT * FROM".$this->tableName;

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query,array(),QueryType::StoredProcedure);

        }
        catch(\PDOException $ex){
            throw $ex;
        }
        return $result;
    }

    public function getCinema($id){

        try{
            $query = "SELECT * FROM".$this->tableName "WHERE ".$this->tableName.".id ='$id'";

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query,array(),QueryType::StoredProcedure);
        }
        catch(\PDOException $ex){
            throw $ex;
        }

        return $result;
    }

    public function delete($id){ //Sin terminar no vimos delete from
       
        try{
            $query = "DELETE FROM". $this->tableName." WHERE ". $this->tableName. ".id ='$id'";
            $this->connection->ExecuteNonQuery($query,QueryType::StoredProcedure);
        }
        catch(\PDOException $ex){
            throw $ex;
        }
        
    }
 // faltan los update/modify pero los deje para lo ultimo,primero tiene que andar el resto

}

?>