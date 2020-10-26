<?php 
    namespace DAO;

    use DAO\IAuditoriumDAO as IAuditoriumDAO;
    use Models\Auditorium as Auditorium;
    
    class AuditoriumDAO implements IAuditoriumDAO{
        
        private $auditoriumList = array ();


        public function Add($newAuditorium){
            $this->retrieveData();
            if ($this->chekExistence($newAuditorium->getName(),$newAuditorium->getCinemaId())==0){
    
                $newAuditorium->setId($this->nextId());
                array_push($this->auditoriumList, $newAuditorium);
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
            return $this->auditoriumList;
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

        public function nextId(){
            $id = 0;
            $this->retrieveData();
    
            foreach($this->auditoriumList as $value){
                $id = $value->getId();
            }
    
            return $id + 1;
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
    
            foreach ($this->auditoriumList as $auditorium) {
                $valueArray['id'] = $auditorium->getId();
                $valueArray['cinemaId'] = $auditorium->getCinemaId();
                $valueArray['name'] = $auditorium->getName();
                $valueArray['capacity'] = $auditorium->getCapacity();
                $valueArray['ticketValue'] = $auditorium->getTicketValue();
    
                array_push($arrayToEncode, $valueArray);
    
            }
            $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
            file_put_contents(dirname(__DIR__) .'/Data/auditorium.json', $jsonContent);
        }

        public function retrieveData(){
            $this->auditoriumList = array();
    
            $jsonPath = $this->GetJsonFilePath();
    
            $jsonContent = file_get_contents($jsonPath);
            
            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();
    
            foreach ($arrayToDecode as $valueArray) {
                $auditorium = new Auditorium();
                $auditorium->setId($valueArray['id']);
                $auditorium->setCinemaId($valueArray['cinemaId']);
			    $auditorium->setName($valueArray['name']);
			    $auditorium->setCapacity($valueArray['capacity']);
			    $auditorium->setTicketValue($valueArray['ticketValue']);
                
                array_push($this->auditoriumList, $auditorium);
            }
        }

        function GetJsonFilePath(){

            $initialPath = "Data/auditorium.json";
            if(file_exists($initialPath)){
                $jsonFilePath = $initialPath;
            }else{
                $jsonFilePath = "../".$initialPath;
            }
    
            return $jsonFilePath;
        }
    }
?>