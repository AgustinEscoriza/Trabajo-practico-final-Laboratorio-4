<?php
    namespace Controllers;

    use DAO\MovieDAO as MovieDAO;
    use \DateTime as NewDT;
    use DAO\CinemaDAOmysql as CinemaDAO;
    use DAO\FunctionDAOMySQL as FunctionDAO;
    use DAO\BillboardDAO as BillboardDAO;
    use DAO\AuditoriumDAOmysql as AuditoriumDAO;
    use Models\Cine as Cine;
    use Models\Functions as Functions;
    use Models\Movie as Movie;
    use Models\Genre as Genre;
    use Models\Lenguage as Lenguage;
    use Models\ProductionCompany as ProductionCompany;
    use Models\ProductionCountry as ProductionCountry;

    class FunctionController{

        private $movieDAO;
        private $dateGlobal;
        public function __construct(){

            $this->movieDAO = new MovieDAO();
            $this->CinemaDAO = new CinemaDAO();
            $this->auditoriumDAO = new AuditoriumDAO();
            $this->functionDAO = new FunctionDAO();
            $this->billboardDAO = new BillboardDAO();
            $this->dateGlobal = new NewDT('today');
        }

        public function showAddView ($cinemaId,$auditoriumId,$addMessage="")
        {
            
            $moviesList = $this->movieDAO->getNowPlayingMovies();
            $cinemaList = $this->CinemaDAO->getAll();
            if($auditoriumId == 0)
            {
                $auditoriumsList = $this->auditoriumDAO->getAuditoriumbyCinemaId($cinemaId);
            }
            else
            {
                $auditoriumsList = $this->auditoriumDAO->getAuditorium($auditoriumId);
                foreach($auditoriumsList as $result)
                {
                    $auditorium = $result;
                }
            }
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
            echo  "<script> alert ('La Funcion se agrego con Exito'); </script>)";
            $this->showAddView(0,$auditoriumId);
        }
    }
?>