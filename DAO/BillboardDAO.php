<?php
namespace DAO;

    use DAO\IBillboardDAO as IBillboardDAO;
    use Models\Cine as Cine;
    use Models\Movie as Movie;
    use Models\Billboard as Billboard;
    use Models\Genre as Genre;
    use Models\Functions as Functions;
    use Models\Lenguage as Lenguage;
    use Models\ProductionCompany as ProductionCompany;
    use Models\ProductionCountry as ProductionCountry;  

class BillboardDAO implements IBillboardDAO
{    
    private $billboardsList = array ();

    public function Add($newFunction){
        $this->retrieveData();
        if ($this->chekExistence($newFunction->getName(),$newFunction->getCinemaId())==0){

            $newAuditorium->setId($this->nextId());
            array_push($this->functionsList, $newFunction);
            $this->saveData();
        }else{
            echo  "<script> alert ('El auditorium que intenta agregar ya fue ingresado.'); </script>)";
            require_once(VIEWS_PATH."auditorium-add.php");
        }
       }

    public function chekExistence ($name,$cinemaId)
    {
    $flag = 0;
    $this->retrieveData();
    $newList = array();
    foreach ($this->auditoriumList as $auditorium) {

        if($auditorium->getCinemaId() == $cinemaId){

            if($auditorium->getName() != $name){
                
            }else{
                $flag = 1;
            }
        }
    }
    return $flag;   
        
    }

    public function getAll(){
        $this->retrieveData();
        return $this->billboardsList;
    }

    public function getBillboardByCinemaId($cinemaId)
    {
        $this->retrieveData();

        $bilboardById = array ();
        
        if($this->billboardsList != NULL){
            
            foreach($this->billboardsList as $billboard){
                if($billboard->getCinemaId() == $cinemaId){
                    $bilboardById = $billboard;
                }
            }
        }
        return $bilboardById;
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

    public function nextId(){
        $id = 0;
        $this->retrieveData();

        foreach($this->billboardsList as $value){
            $id = $value->getId();
        }

        return $id + 1;
    }

    public function delete($id){       
    
        $this->retrieveData();

        foreach ($this->billboardsList as $auditoriumValue) {

            if ($auditoriumValue->getId() == $id) {
                $key = array_search($auditoriumValue, $this->auditoriumList);
                unset($this->auditoriumList[$key]);
            }
        }
        $this->SaveData();
       }


    public function saveData(){
        $arrayToEncode = array();

        foreach ($this->billboardsList as $billboard)
        {
            $i=0;
            $valueArray['id'] = $billboard->getId();
            $valueArray['cinemaId'] = $billboard->getDate();
            foreach($billboard->getFunctionsList() as $function)
            {
                $valueArray['functionsList'][$i] = $function;
                $i++;
            }


            array_push($arrayToEncode, $valueArray);

        }
        $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
        file_put_contents(dirname(__DIR__) .'/Data/Billboard.json', $jsonContent);
    }

    public function retrieveData(){
        $this->billboardsList = array();

        $jsonPath = $this->GetJsonFilePath();

        $jsonContent = file_get_contents($jsonPath);
        
        $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

        foreach ($arrayToDecode as $valueArray) {

            $billboard = new Billboard();
            $billboard->setId($valueArray['id']);
            $billboard->setCinemaId($valueArray['cinemaId']);

            array_push($this->billboardsList, $billboard);
        }
    }

    function GetJsonFilePath(){

        $initialPath = "Data/Billboard.json";
        if(file_exists($initialPath)){
            $jsonFilePath = $initialPath;
        }else{
            $jsonFilePath = "../".$initialPath;
        }

        return $jsonFilePath;
    }
}
?>