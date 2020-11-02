<?php

namespace DAO;

use Models\Functions;
use Models\Auditorium;
use Models\Movie;
use \Exception as Exception;
use DAO\QueryType as QueryType;

class FunctionDAOmysql 
{
    private $connection;
    private $tableName = "functions";

    public function __construct(){

        $this->connection = new Connection();

    }

    public function getMoviesByDate(){

        try{
            $query = "SELECT movie.id, movie.title, movie.img, movie.realeseDate, movie.language, movie.overview FROM movie JOIN function on function.idmovie = movie.id WHERE function.date ='$date'";

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query,array(),QueryType::Query);

            $moviesList = array();

            foreach($result as $row){
                
                $movie = new Movie();
                $movie->setId($row["idMovie"]);
                $movie->setTitle($row["title"]);
                $movie->setOriginalTitle($row["originalTitle"]);
                $movie->setPosterpath($row["originalLanguage"]);
                $movie->setReleaseDate($row["realeseDate"]);
                $movie->setOriginalLanguage($row["posterPath"]);
                $movie->setOverview($row["overview"]);
                $movie->setGenres($row["genre"]);
                array_push($moviesList, $movie);

            }
            return $moviesList;
        }
        catch (Exception $ex) {
            throw $ex;
        }
    }

    public function add(Functions $function,Movie $movie,Auditorium $auditorium){
        try {


            $query = "INSERT INTO " . $this->tableName . " (idAuditorium, idMovie, date, tickets) VALUES (:idAuditorium, :idMovie, :date, :ticketsSold);";

            $parameters["idAuditorium"] = $auditorium->getId();
            $parameters["idMovie"] = $movie->getId();
            $parameters["date"] = $function->getDate();
            $parameters["tickets"] = $function->getTickets();


            $this->connection->executeNonQuery($query, $parameters,QueryType::Query);

        } catch (\PDOException $ex) {
            throw $ex;
        }

    }

    public function getMovies()
    {
        try {
            $movieList = array();

            $query = "SELECT movies.id, movies.title, movies.posterPath, movies.realeseDate, movies.originalLanguage, movies.overview FROM movies join functions on functions.idmovie = movies.id";
            $resultSet = $this->connection->execute($query,array(),QueryType::Query);

            if (!empty($resultSet)) {
                foreach ($resultSet as $row) {

                    $movie = new Movie();
                    $movie->setId($row["idMovie"]);
                    $movie->setTitle($row["title"]);
                    $movie->setOriginalTitle($row["originalTitle"]);
                    $movie->setPosterpath($row["originalLanguage"]);
                    $movie->setReleaseDate($row["realeseDate"]);
                    $movie->setOriginalLanguage($row["posterPath"]);
                    $movie->setOverview($row["overview"]);
                    $movie->setGenres($row["genre"]);

                    array_push($movieList, $movie);
                }
            }

            return $movieList;
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }
    public function getAll()
    {
        try {
            $functionList = array();

            $query = "SELECT f.id, f.date, f.tickets , f.idMovie, f.idAuditorium, m.title, m.posterPath, m.realeseDate, m.originalLanguage, m.overview,
            r.name, r.capacity, r.ticketValue FROM functions as f join movies as m on f.idmovie = m.id join auditorium as r on r.id = f.idAuditorium";
            $result = $this->connection->execute($query,array(),QueryType::Query);

            if (!empty($result)) {
                foreach ($result as $row) {


                    $function = new Functions();
                    $function->setId($row["id"]);
                    $function->setDate($row["date"]);
                    $function->setTickets($row["tickets"]);


                    $movie = new Movie();
                    $movie->setId($row["idMovie"]);
                    $movie->setTitle($row["title"]);
                    $movie->setOriginalTitle($row["originalTitle"]);
                    $movie->setPosterpath($row["originalLanguage"]);
                    $movie->setReleaseDate($row["realeseDate"]);
                    $movie->setOriginalLanguage($row["posterPath"]);
                    $movie->setOverview($row["overview"]);
                    $movie->setGenres($row["genre"]);

                    $auditorium = new Auditorium();
                    $auditorium->setId($row["idAuditorium"]);
                    $auditorium->setName($row["name"]);
                    $auditorium->setCapacity($row["capacity"]);
                    $auditorium->setTicketValue($row["ticketValue"]);

                    $function->setMovie($movie);
                    $function->setAuditorium($auditorium);


                    array_push($functionList, $function);
                }
            }

            return $functionList;
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

    public function getById($functionId)
    {

        try {
            
            $query = "SELECT f.id, f.date, f.tickets , f.idMovie, f.idAuditorium, m.title, m.posterPath, m.realeseDate, m.originalLanguage, m.overview,
            r.name, r.capacity, r.ticketValue FROM functions as f join movies as m on f.idmovie = m.id join auditorium as r on r.id = f.idAuditorium WHERE f.id = $functionId";
            $result = $this->connection->execute($query,array(),QueryType::Query);

            if (!empty($result)) {
                foreach ($result as $row) {

                    $function = new Functions();
                    $function->setId($row["id"]);
                    $function->setDate($row["date"]);
                    $function->setTickets($row["tickets"]);


                    $movie = new Movie();
                    $movie->setId($row["idMovie"]);
                    $movie->setTitle($row["title"]);
                    $movie->setOriginalTitle($row["originalTitle"]);
                    $movie->setPosterpath($row["originalLanguage"]);
                    $movie->setReleaseDate($row["realeseDate"]);
                    $movie->setOriginalLanguage($row["posterPath"]);
                    $movie->setOverview($row["overview"]);
                    $movie->setGenres($row["genre"]);

                    $auditorium = new Auditorium();
                    $auditorium->setId($row["idAuditorium"]);
                    $auditorium->setName($row["name"]);
                    $auditorium->setCapacity($row["capacity"]);
                    $auditorium->setTicketValue($row["ticketValue"]);

                    $function->setMovie($movie);
                    $function->setAuditorium($auditorium);
            }

            return $function;
            }
        } 
        catch (\PDOException $ex) {
            throw $ex;
        }
    }

}