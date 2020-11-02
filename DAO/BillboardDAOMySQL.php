<?php 
    namespace DAO;

    use DAO\ICinemaDAO as ICinemaDAO;
    use DAO\Connection as Connection;
    use DAO\QueryType as QueryType;
    use Models\Cinema as Cinema;
    use Models\Movie as Movie;

// NO SE USA, esta relacion esta en la funcion, no en esta tabla, hay que borrarla y la relacion movie con cinema sale de la sala que esta en la funcion

    class BillBoardDAOmysql implements IBillBoardDAO{

        private $connection;
        private $tableName = "moviesXCinema";

    public function __construct(){

        $this->connection = new Connection();
    }
    public function Add(Cinema $cinema,Movie $movie){

        try{
            $query = "INSERT INTO ".$this->tableName." (idMovie, idCinema) VALUES (:idMovie, :idCinema)";

        
            $parameters["idCinema"] = $cinema->getId();
            $parameters["idMovie"] = $movie->getId();


            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query,$parameters,QueryType::Query);
        }
        catch(\PDOException $ex){
            throw $ex;
        }
        
    }

    public function getMoviesByCinemaId($cinemaId){

        try {
            $query = "SELECT * FROM movies as m INNER JOIN " . $this->tableName . " as mxc ON m.id = mxc.idMovie WHERE mxc.cinemaId =" . $cinemaId;
            $resultSet = $this->connection->Execute($query,array(),QueryType::Query);
            $moviesList = array();
            foreach ($resultSet as $row) {

                $movie = new Movie();
                $movie->setId($row["idMovie"]);
                $movie->setTitle($row["title"]);
                $movie->setTitle($row["originalTitle"]);
                $movie->setImg($row["originalLanguage"]);
                $movie->setReleaseDate($row["realeseDate"]);
                $movie->setLanguage($row["posterPath"]);
                $movie->setOverview($row["overview"]);
                $movie->setGenres($row["genre"]);
                array_push($moviesList, $movie);
            }
            return $moviesList;
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

    public function isOnBillboard(Movie $movie,Cinema $cinema){
        try {

            $movieId = $movie->getId();
            $cinemaId = $cinema->getId();
            
            $query = "SELECT * FROM " . $this->tableName . " WHERE  idMovie=".$movieId." AND idCinema=".$cinemaId;

            $resultSet = $this->connection->execute($query,array(),QueryType::Query);
            
            if($resultSet != null){
                $exist = true;
            }
            else{
                $exist = false;
            }
           
            return $exist;
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

}

?>