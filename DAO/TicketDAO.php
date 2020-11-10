<?php

namespace DAO;

use Models\Ticket;
use Models\User;
use Models\FunctionS;
use Models\Movie;

class TicketDAO implements ITicketDAO{

    private $connection;
    private $tableName = "tickets";

    public function __construct(){

        $this->connection = new Connection();

    }

    public function add(Ticket $ticket)
    {
        try{

            $query="INSERT INTO ".$this->tableName. " ( idUser, idFunction, quantity, price, ticketStatus) VALUES ( :idUser, :idFunction, :quantity, :price, :ticketStatus);";
            $parameters["idUser"] = $ticket->getUser()->getIdUser();
            $parameters["idFunction"] = $ticket->getFunction()->getId();
            $parameters["quantity"] = $ticket->getQuantity();
            $parameters["price"] = $ticket->getPrice();
            $parameters["ticketStatus"] = 1;

            $this->connection->executeNonQuery($query,$parameters,QueryType::Query);    
        }
        catch(\PDOException $ex){
            throw $ex;
        }
    }
    public function CheckTicketsStatus($idFunction)
    {
        $status = false;

        $functionsList = GetTicketsByFunctionId($idFunction);

        if(empty($functionsList))
        {
            $status = true;
        }

        return $status;
    }

    public function GetTicketsByFunctionId($idFunction)
    {
        try{
        $query = "SELECT * FROM ".$this->tableName." WHERE ".$this->tableName.".idFunction ='$idFunction' 
                                                    and".$this->tableName.".ticketStatus = 1" ;

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

    public function getTicketsByUser(User $user){
        try{
            $userId = $user->getIdUser();

            //$query= "SELECT t.idTicket,t.quantity,t.price,t.status,f.functionDate,f.functionTime,movies.title,movies.idMovie FROM tickets as t JOIN functions as f on f.idFunction = t.idFunction JOIN movies on f.idMovie = movies.idMovie WHERE t.idUser ='$userId'";
            $query= "SELECT * FROM tickets  WHERE idUser ='$userId'";

            $result = $this->connection->execute($query,array(),QueryType::Query);
        
            if(!empty($result)){

               return $this->mapear($result);

            }
            else{
                return false;
            }
        }
        catch (\PDOException $ex) {
            throw $ex;
        }
    }
    public function getTicketsSoldByFunctionId($functionId){
        try{

            $query= "SELECT count(tickets.idTicket) as ticketsSold FROM tickets WHERE tickets.idFunction ='$functionId'";

            $result = $this->connection->execute($query,array(),QueryType::Query);
  
            
            return $result[0]['ticketsSold'];

        }
        catch (\PDOException $ex) {
            throw $ex;
        }
    }
    

    protected function mapear($value) {
        
        $value = is_array($value) ? $value : [];
        
        $resp = array_map(function($i){
            $ticket = new Ticket();
            $ticket->setId($i["idTicket"]);
            $ticket->setFunction($i["idFunction"]);
            $ticket->setQuantity($i["quantity"]);
            $ticket->setPrice($i["price"]); 
            $ticket->setStatus($i["ticketStatus"]);
            //$ticket->setStatus($i["status"]);
            //$ticket->setStatus($i["status"]);
            //$ticket->setStatus($i["status"]);
            return $ticket;
            var_dump($ticket);
        }, $value);   // $value es cada array q quiero convertir a objeto
        return $resp;
    }
}


?>