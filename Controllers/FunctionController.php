<?php
    namespace Controllers;

    use DAO\MovieDAOmysql as MovieDAO;
    use \DateTime as NewDT;
    use DAO\CinemaDAOmysql as CinemaDAO;
    use Controllers\BillboardController as BillboardController;
    use DAO\FunctionDAOMySQL as FunctionDAO;
    use DAO\BillboardDAO as BillboardDAO;
    use DAO\AuditoriumDAOmysql as AuditoriumDAO;
    use DAO\TicketDAO as TicketDAO;
    use Models\Cine as Cine;
    use Models\Functions as Functions;
    use Models\Movie as Movie;
    use Models\Genre as Genre;
    use Models\Lenguage as Lenguage;
    use Models\ProductionCompany as ProductionCompany;
    use Models\ProductionCountry as ProductionCountry;

    class FunctionController{

        private $movieDAO;
        private $cinemaDAO;
        private $dateGlobal;
        private $billboardController;
        public function __construct(){

            $this->movieDAO = new MovieDAO();
            $this->cinemaDAO = new CinemaDAO();
            $this->auditoriumDAO = new AuditoriumDAO();
            $this->functionDAO = new FunctionDAO();
            $this->billboardDAO = new BillboardDAO();
            $this->ticketDAO = new TicketDAO();
            $this->dateGlobal = new NewDT('today');
            $this->billboardController = new BillboardController();
        }

        public function showAddView ($cinemaId,$auditoriumId,$addMessage="")
        {            
            $moviesList = $this->movieDAO->getAll();
            $cinemaList = $this->cinemaDAO->getAll();
    
            if($auditoriumId == 0)
            {
                $auditoriumsList = $this->auditoriumDAO->getAuditoriumbyCinemaId($cinemaId,1);
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

        public function Add($cinemaId, $auditoriumId, $movieId, $date, $time, $addMessage="")
        {            
            $newFunction = new Functions();
            $newFunction->setDate($date);
            $newFunction->setTime($time);
            $newFunction->setMovieId($movieId); 
            $auditorium = $this->auditoriumDAO->getAuditorium($auditoriumId)[0];
            $resp = $this->movieDAO->getMovie($newFunction->getMovieId());
                    $runtime = $resp["runtime"];

            if ((!$existence = $this->chekExistence($movieId,$date)) && (!$chkDate = $this->checkDate($auditoriumId, $date, $time ,$runtime)))
            {
                $resp = $this->functionDAO->Add($cinemaId, $auditoriumId,$newFunction);   

                $addMessage = ($resp == 1) ? "Sa Ha Agregado Con Exito La Funcion La Sala: ".$auditorium->getName().
                                            ", Pelicula: ".$resp["title"].", 
                                            Para La Fecha: ".date('l',strtotime($date))." ".date('d',strtotime($date)).", ".$time." HS" 
                                            : "Ha Habido Errores En La Creacion de La Funcion, Revise El Listado";

                $this->billboardController->ShowBillboard($cinemaId, $addMessage);     
            }
            else
            {
                $addMessage = ($existence) ? "La Pelicula Sera Reproducida En La Fecha Seleccionada En Otro Cine "
                            : ($chkDate) ? "La Pelicula No Puede Ser Reproducida En Ese Horario Ya Que Hay Otra Funcion Establecida"
                            :              "Ha Habido Errores De Validacion, Revise El Listado";

                $this->billboardController->ShowBillboard($cinemaId, $addMessage);
            }
        } 

        public function chekExistence ($idMovie,$date)
        {
            $flag = false;
            
             $resp = $this->functionDAO->GetFunctionsByMovieId($idMovie);

            if($resp){
                foreach ($resp as $function) {
                    if($function->getDate() == $date){
    
                        $flag = true;  
                        $this->functionMessage ="La Pelicula Que Desea Agregar Ya Sera Reproducida En Otro Cine En La Fecha Seleccionada";
                    }               
                }
                return $flag; 
            }           
            else
            {
                return false;
            }        
        }

   


    public function checkDate($idAuditorium,$date, $time, $newFunctionRuntime)
    {
        $flag = false;
        $resp = $this->functionDAO->GetFunctionsByAuditoriumId($idAuditorium,$date);
            if($resp){        
                //Seteo el tiempo de inicio de la Nueva Funcion X2 para tomar inicio y final        
                $newFunctionTimeStart = new NewDT($time);
                $newFunctionTimeEnd = new NewDT($time);

                //agrego la duracion de la nueva funcion a la variable End
                $newFunctionTimeEnd->modify('+'.$newFunctionRuntime.' minutes');

                //convierto las variables a string para trabajarlas
                $newFunctionTimeStartConvert = strtotime($newFunctionTimeStart->format("H:i:s"));
                $newFunctionTimeEndConvert = strtotime($newFunctionTimeEnd->format("H:i:s"));

                //realizo el calculo de horas mas minutos para trabajar la comparacion como un entero
                $newFunctionTimeStartInt =(((idate('H',$newFunctionTimeStartConvert)) * 60) + idate('i',$newFunctionTimeStartConvert));
                $newFunctionTimeEndInt =(((idate('H',$newFunctionTimeEndConvert)) * 60) + idate('i',$newFunctionTimeEndConvert) + 15);
                foreach ($resp as $function) {
                    //Traigo el Objeto Movie con el ID, para extraer la duracion de la funcion
                    foreach($function as $fun){
                        echo 'DATO: '.$fun.'<br>';
                    }
                    $respFunction = $this->movieDAO->getMovie($function->getMovieId());
                    $runtime = $respFunction["runtime"];
                    $endFunction =  new NewDT ($function->getTime());
                    $startFunction =  new NewDT ($function->getTime());                    
                    $endFunction->modify('+'.$runtime.' minutes');
                    

                    $startFunctionConvert = strtotime($startFunction->format("H:i:s"));
                    $endFunctionConvert = strtotime($endFunction->format("H:i:s"));
                    

                    $startFunctionInt = (((idate('H',$startFunctionConvert)) * 60) + idate('i',$startFunctionConvert));
                    $endFunctionInt =(((idate('H',$endFunctionConvert)) * 60) + idate('i',$endFunctionConvert) + 15);

                    
                    if((($startFunctionInt < $newFunctionTimeStartInt) && ($newFunctionTimeStartInt < $endFunctionInt))
                    || (($newFunctionTimeStartInt < $startFunctionInt) && ($startFunctionInt < $newFunctionTimeEndInt))){    
                        $flag = true; 
                        $this->functionMessage ="El Horario No Puede Ser Seleccionado Ya Que No Respeta las Reglas de Horarios de Funciones";
                    }
                
            }
            return $flag; 
        }
        else
        {
            return false;
        }                         
    }


    

        public function ShowFunctions($cinemaId, $auditoriumId, $idMovie)
        {
            $functionsList = $this->functionDAO->getFunctionsByCinema($cinemaId,$idMovie);

            if(empty($functionsList))
            {
                $infoMessage="No Hay Funciones Programadas";
            }
            $movie = $this->movieDAO->getByMovieId($idMovie);

            
            
            require_once(VIEWS_PATH."function-list.php");
        }

        public function ChangeFunctionsStatus($idFunction)
        {
            if($this->ticketDAO->CheckTicketsStatus($idFunction))
            {
                $result = $this->functionDAO->ChangeFunctionsStatus($idFunction);

                $this->showFullList(($result==1) ? "La Funcion Ha Sido Eliminada Correctamente" : "Revise el Listado Por Posibles Errores de Eliminacion");
            }
            //falta setear el mensaje si no se puede eliminar
            $this->billboardController->showFullList("La Funcion no Puede Eliminarse, Ya que hay Tickets Emitidos Para La Misma");
        }

        public function FunctionsToCinema($idMovie)
        {
            $functionsByCinemaList = array();
            $cinemaList = $this->cinemaDAO->getAll();

            foreach($cinemaList as $cinema)
            {
                
                $functions["functions"] = $this->functionDAO->getFunctionsByCinema($cinema->getId(),$idMovie);
                $functions["cinemaName"] = $cinema->getName();
                $functions["disponibility"]= ( empty($functions["functions"])) ? "No Hay Funciones Para Este Cine" : "";
                array_push($functionsByCinemaList,$functions);
            } 
            if(empty($functionsByCinemaList))
            {
                $infoMessage="No Hay Funciones Programadas";
            }
            $movie = $this->movieDAO->getByMovieId($idMovie);
            $genres= $this->movieDAO->getGenresByMovieId($movie->getId());
            foreach($genres as $genre){
                $movie->setGenre($genre);
            }
            require_once(VIEWS_PATH."function-list.php");
        }              
    }      
?>