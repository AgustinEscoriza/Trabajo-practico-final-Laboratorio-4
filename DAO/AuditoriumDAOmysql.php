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
                $query = "INSERT INTO auditoriums (name,idCinema,ticketValue,capacity) VALUES (:name, :idCinema, :ticketValue, :capacity)";

                $parameters["name"] = $auditorium->getName();
                $parameters["idCinema"] = $idCinema;
                $parameters["capacity"] = $auditorium->getCapacity();
                $parameters["ticketValue"] = $auditorium->getTicketValue();

                $this->connection = Connection::GetInstance();

                $this->connection->ExecuteNonQuery($query,$parameters,QueryType::Query);
            }
            catch(\PDOException $ex){
                throw $ex;
            }
            
        }

        public function getAuditoriumByCinemaId($cinemaId){

            $query = "SELECT * FROM auditoriums WHERE idCinema ='$cinemaId'";

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query,array(),QueryType::Query);

   //    foreach($result as $row){

   //        $auditorium = new Auditorium();
   //        $auditorium->setId($row["idAuditorium"]);
   //        $auditorium->setName($row["name"]);
   //        $auditorium->setCapacity($row["capacity"]);
   //        $auditorium->setTicketValue($row["ticketValue"]);

   //        array_push($auditoriumList,$auditorium);
   //    }
   //    return $auditoriumList;
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