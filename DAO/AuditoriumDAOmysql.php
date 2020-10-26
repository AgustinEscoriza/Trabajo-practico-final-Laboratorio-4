<?php 
    namespace DAO;

    use DAO\IDAO as IDAO;
    use DAO\Connection as Connection;
    use DAO\QueryType as QueryType;
    use Models\Auditorium as Auditorium;
    
    class AuditoriumDAO implements IDAO{

        private $connection;
        private $tableName = "auditorium";


        public function Add(Auditorium $auditorium){

            try{
                $query = "INSERT INTO ". $this->tableName. "(name,price,capacity) VALUES (:name, :price, :capacity)";

                $parameters["name"] = $auditorium->getName();
                $parameters["Capacity"] = $auditorium->getCapacity();
                $parameters["ticketValue"] = $auditorium->getTicketValue();

                $this->connection = Connection::GetInstance();

                $this->connection->ExecuteNonQuery($query,$parameters,QueryType::StoredProcedure);
            }
            catch(\PDOException $ex){
                throw $ex;
            }
            
        }

        public function getAuditoriumByCinemaId($cinemaId){
            $auditoriumList = array();

            $query = "SELECT * FROM".$this->tableName "WHERE ".$this->tableName.".id ='$cinemaId'";

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query,array(),QueryType::StoredProcedure);

            foreach($result as $row){

                $auditorium = new Auditorium();
                $auditorium->setId($row["id"]);
                $auditorium->setName($row["name"]);
                $auditorium->setCapacity($row["capacity"]);
                $auditorium->setTicketValue($row["ticketValue"]);

                array_push($auditoriumList,$auditorium);
            }
            return $auditoriumList;
        }

        public function getAuditorium($id){

            $query = "SELECT * FROM".$this->tableName "WHERE ".$this->tableName.".id ='$id'";

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query,array(),QueryType::StoredProcedure);

            return $result;
        }

        public function delete($id){
            $query = "CALL Auditorium_Delete(?)";

            $parameters["id"] = $id;

            $this->connection = Connection::GetInstance();
            
            $this->connection->ExecuteNonQuery($query,$parameters,QueryType::StoredProcedure);
            
        }

    }
?>