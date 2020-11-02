<?php
namespace DAO;

    use DAO\IBillboardDAO as IBillboardDAO;
    use Models\Cine as Cine;
    use Models\Movie as Movie;
    use Models\Genre as Genre;
    use Models\Functions as Functions;
    use Models\Lenguage as Lenguage;
    use Models\ProductionCompany as ProductionCompany;
    use Models\ProductionCountry as ProductionCountry;  

class FunctionDAO implements IFunctionDAO
{    
    private $functionsList = array ();

    public function Add($cinema, $auditoriumId, Functions $newFunction){
        $this->retrieveData();
        
        if (!$this->chekExistence($newFunction->getMovieId(),$newFunction->getDate())){
            $newFunction->setId(sizeof($this->functionsList));
            array_push($this->functionsList, $newFunction);
            $this->saveData();

        }else{
            echo  "<script> alert ('La Funcion que intenta agregar no ha podido ser ingresada.'); </script>)";
            require_once(VIEWS_PATH."cinema-list.php");
        }
       }

    public function chekExistence ($movieId,$date)
    {
        $flag = false;
        $this->retrieveData();
        foreach ($this->functionsList as $function) {

            if($function->getMovieId() == $movieId){
                if($function->getDate() == $date){

                    $flag = true;  

                }
            }
        }
        return $flag;          
    }

    public function getAll(){
        $this->retrieveData();
        return $this->functionsList;
    }

    public function getAuditoriumbyCinemaId($cinemaId)
    {
    $this->retrieveData();

    $auditoriumById = array ();
    
    if($this->auditoriumList != NULL){
        
        foreach($this->auditoriumList as $auditoriumValue){
            if($auditoriumValue->getCinemaId() == $cinemaId){
                 array_push($auditoriumById,$auditoriumValue);
            }
        }
    }
        return $auditoriumById;
    }

    public function getAuditorium($id){
        $this->retrieveData();
        $auditorium = new Auditorium();
        foreach($this->auditoriumList as $auditoriumValue){
            if($auditoriumValue->getId() == $id){
                 $auditorium = $auditoriumValue;
            }
        }

        return $auditorium;
    }

    public function delete($id){       
    
        $this->retrieveData();

        foreach ($this->auditoriumList as $auditoriumValue) {

            if ($auditoriumValue->getId() == $id) {
                $key = array_search($auditoriumValue, $this->auditoriumList);
                unset($this->auditoriumList[$key]);
            }
        }
        $this->SaveData();
       }


    public function saveData(){
        $arrayToEncode = array();

        foreach ($this->functionsList as $function) {
            echo 'DAO ID: '.$function->getId().'<br>';
            echo 'DAO AUDITORIUM: '.$function->getAuditoriumId().'<br>';
            //$valueArray['id'] = $function->getId();
            $valueArray['auditoriumId'] = $function->getAuditoriumId();
            $valueArray['date'] = $function->getDate();
            $valueArray['time'] = $function->getTime();
            $valueArray['movieId'] = $function->getMovieId();

            array_push($arrayToEncode, $valueArray);

        }
        $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
        file_put_contents(dirname(__DIR__) .'/Data/Function.json', $jsonContent);
    }

    public function retrieveData(){
        $this->functionsList = array();

        $jsonPath = $this->GetJsonFilePath();

        $jsonContent = file_get_contents($jsonPath);
        
        $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

        foreach ($arrayToDecode as $valueArray) {

            $function = new Functions();
            $function->setId($valueArray['id']);
            $function->setAuditoriumId($valueArray['auditoriumId']);
            $function->setDate($valueArray['date']);
            $function->setTime($valueArray['time']);
            $function->setMovieId($valueArray['movieId']);       
            
            array_push($this->functionsList, $function);
        }
    }

    function GetJsonFilePath(){

        $initialPath = "Data/Function.json";
        if(file_exists($initialPath)){
            $jsonFilePath = $initialPath;
        }else{
            $jsonFilePath = "../".$initialPath;
        }

        return $jsonFilePath;
    }
}
?>