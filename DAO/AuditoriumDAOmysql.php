<?php 
    namespace DAO;

    use DAO\IAuditoriumDAO as IAuditoriumDAO;
    use DAO\Connection as Connection;
    use DAO\QueryType as QueryType;
    use Models\Auditorium as Auditorium;
    
    class AuditoriumDAOmysql implements IAuditoriumDAO{ //falta validar que no haya con mismo nombre en el mismo cine

        private $connection;
        private $tableName = "auditoriums";


        public function __construct(){

            $this->connection = new Connection();
        }


        public function Add(Auditorium $auditorium,$idCinema){

            try{
                $query = "INSERT INTO auditoriums (name,idCinema,ticketValue,capacity,auditoriumStatus) 
                                    VALUES (:name, :idCinema, :ticketValue, :capacity, :auditoriumStatus)";

                $parameters["name"] = $auditorium->getName();
                $parameters["idCinema"] = $idCinema;
                $parameters["capacity"] = $auditorium->getCapacity();
                $parameters["ticketValue"] = $auditorium->getTicketValue();
                $parameters["auditoriumStatus"] = 1;

                $this->connection = Connection::GetInstance();

                $this->connection->ExecuteNonQuery($query,$parameters,QueryType::Query);
            }
            catch(\PDOException $ex){
                throw $ex;
            }
            
        }

        public function existName($name,$idCinema)
        {
            $exists = false;
            try {
                $query = "SELECT * FROM auditoriums WHERE auditoriums.name ='$name' AND auditoriums.idCinema ='$idCinema'";
                $resultSet = $this->connection->execute($query,array(),QueryType::Query);

                if (!empty($resultSet)) {
                    $exists = true;
                }
                return $exists;
            } catch (\PDOException $ex) {
                throw $ex;
            }
        }

        public function getAuditoriumByCinemaId($cinemaId, $status)
        {

            $query = "SELECT * FROM auditoriums WHERE idCinema ='$cinemaId' AND auditoriumStatus = 1";
            //$query = ($status==-1) ? "SELECT * FROM auditoriums WHERE idCinema ='$cinemaId'"
            //                        :"SELECT * FROM auditoriums WHERE idCinema ='$cinemaId' AND auditoriumStatus ='$status'";

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query,array(),QueryType::Query);

            if(!empty($result)){
                return $this->mapear($result);
            }
            else{
                return false;
            }
        }

        public function GetAuditoriumByFunctionId($idFunction)
        {
            $query = "SELECT * FROM auditoriums 
            INNER JOIN Functions 
            ON ".$this->tableName.".idAuditorium = Functions.idAuditorium 
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

        public function getAuditorium($id){

            $query = "SELECT * FROM auditoriums WHERE ".$this->tableName.".idAuditorium ='$id'";

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query,array(),QueryType::Query);

            if(!empty($result)){
                return $this->mapear($result);
            }
            else{
                return false;
            }
        }

        public function delete($id){ 
           
            try{
                $query = "DELETE FROM auditoriums WHERE ". $this->tableName. ".idAuditorium ='$id'";
                $this->connection->ExecuteNonQuery($query,QueryType::Query);
            }
            catch(\PDOException $ex){
                throw $ex;
            }
            
        }

        public function  modify($cinemaId,$name,$capacity,$ticketValue){

            $query = "UPDATE cinemas SET name = :name, capacity = :capacity, ticketValue = :ticketValue WHERE idCinema = $cinemaId";
            
            $parameters['name'] = $name;
            $parameters['capacity'] = $capacity;
            $parameters['ticketValue'] = $ticketValue;
    
            try {
    
            $this->connection = Connection::getInstance();
            $this->connection->ExecuteNonQuery($query, $parameters,QueryType::Query);
    
            }catch(\PDOException $ex) {
    
                throw $ex;
            }
        }
        
        public function getIdCinema($auditoriumId){

            $query = "SELECT * FROM auditoriums WHERE ".$this->tableName.".idAuditorium ='$auditoriumId'";

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query,array(),QueryType::Query);

            if(!empty($result)){
                return $result[0]['idCinema'];
            }
            else{
                return false;
            }
        }

        public function CheckAuditoriumStatus($idCinema)
        {
            $status = false;

            $auditoriumsList = getAuditoriumByCinemaId($idCinema,1);

            if(empty($auditoriumsList))
            {
                $status = true;
            }

            return $status;
        }

        public function ChangeAuditoriumStatus($idAuditorium){
            try{
                
                    $query = "UPDATE auditoriums set auditoriumStatus = 0 WHERE idAuditorium='$idAuditorium'";
    
                    $this->connection = Connection::GetInstance();
                
                   return $this->connection->ExecuteNonQuery($query,array(),QueryType::StoredProcedure);
                
            }
            catch(\PDOException $ex){
                throw $ex;
            }
        }

        protected function mapear($value) {
            $value = is_array($value) ? $value : [];
            $resp = array_map(function($p){
                $a = new Auditorium();
                $a->setId($p['idAuditorium']);
                $a->setName($p['name']);
                $a->setCapacity($p['capacity']);
                $a->setTicketValue($p['ticketValue']);
                return $a;
            }, $value);   // $value es cada array q quiero convertir a objeto
            return $resp;
        }
    }
?>