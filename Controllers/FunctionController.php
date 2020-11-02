<?php
    namespace Controllers;

    use DAO\MovieDAO as MovieDAO;
    use DAO\MovieDAOmysql as MovieDAOmysql;
    use \DateTime as NewDT;
    use DAO\CinemaDAOmysql as CinemaDAOmysql;
    use DAO\AuditoriumDAOmysql as AuditoriumDAOmysql;
    use DAO\FunctionDAOmysql as FunctionDAOmysql;
    use Models\Functions as Functions;

    class FunctionController{

        private $movieDAO;
        private $cinemaDAO;
        private $functionDAO;
        private $dateGlobal;
        
        public function __construct(){

            $this->movieDAO = new MovieDAOmysql();
            $this->CinemaDAO = new CinemaDAOmysql();
            $this->auditoriumDAO = new AuditoriumDAOmysql();
            $this->functionDAO = new FunctionDAOmysql();
            $this->dateGlobal = new NewDT('today');
        }

        public function showAddView ($cinemaId,$auditoriumId,$addMessage="")
        {
            
    //        $moviesList = $this->movieDAO->getNowPlayingMovies();
    //        $cinemaList = $this->CinemaDAO->getAll();
    //        if($auditoriumId == 0)
    //        {
    //            $auditoriumsList = $this->auditoriumDAO->getAuditoriumbyCinemaId($cinemaId);
    //        }
    //        else
    //        {
    //            $auditoriumsList = $this->auditoriumDAO->getAuditorium($auditoriumId);
    //        }

            $moviesList = $this->movieDAO->getAll();
            $date = $this->dateGlobal;

            require_once(VIEWS_PATH."function-add.php");
        }
        

        public function Add($cinemaId, $auditoriumId, $movieId, $date, $time)
        {            
            $newFunction = new Functions();
            $newFunction->setDate($date);
            $newFunction->setTime($time);
            $newFunction->setMovieId($movieId); 

            $this->functionDAO->Add($cinemaId, $auditoriumId, $newFunction);
            $this->showAddView(0,$auditoriumId);
        }
    }
?>