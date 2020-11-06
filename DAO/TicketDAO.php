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

            $query="INSERT INTO ".$this->tableName. " ( idUser, idFunction, quantity, price, status) VALUES ( :idUser, :idFunction, :quantity, :price, :status);";
            $parameters["idUser"] = $ticket->getUser()->getId();
            $parameters["idFunction"] = $ticket->getFunction()->getId();
            $parameters["quantity"] = $ticket->getQuantity();
            $parameters["price"] = $ticket->getPrice();
            $parameters["status"] = $ticket->getStatus();

            $this->connection->executeNonQuery($query,$parameters,QueryType::Query);    
        }
        catch(\PDOException $ex){
            throw $ex;
        }
    }

    public function getTicketsByUser(User $user){
        try{

            $query= "SELECT t.idTicket,t.quantity,t.price,t.status,f.functionDate,f.functionTime,movies.title,movies.idMovie FROM ticket as t JOIN functions as f on f.idFunction = t.idFunction JOIN movies on f.idMovie = movies.idMovie WHERE t.idUser ='$userId'";

            $result = $this->connection->execute($query,array(),QueryType::Query);

            $ticketList = array();

            if(!empty($resultSet)){

                foreach($result as $i){

                    $ticket = new Ticket();
                    $ticket->setId($i["id"]);
                    $ticket->setPrice($i["price"]);
                    $ticket->setQuantity($i["quantity"]);
                    $ticket->setStatus($i["status"]);

                    $function = new Functions();
                    $function->setTime($i["functionTime"]);
                    $function->setDate($i["functionDate"]);

                  //  $movie = new Movie();
                  //  $movie->setTitle($i["title"]);
                  //  $function->setMovie($movie);   no puedo hacer esto porque tenemos el id de movie adentro de la funcion
                    $function->setMovieId($i["idMovie"]);

                    $ticket->setFunction($function);
                
                }

            }


            return $ticketList;
        }
        catch (\PDOException $ex) {
            throw $ex;
        }
    }
}


?>