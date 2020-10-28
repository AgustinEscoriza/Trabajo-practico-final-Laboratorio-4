<?php
    
    namespace DAO;

    use DAO\IMovieDAO as IMovieDAO;
    use DAO\Connection as Connection;
    use DAO\QueryType as QueryType;
    use Models\Cinema as Cinema;

    class MovieDAOmysql implements IMovieDAO{
        private $connection;
        private $tableName = "movies";
        
    }

?>