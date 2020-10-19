<?php 
    namespace DAO;

    use DAO\IDAO as IDAO;
    use Models\Auditorium as Auditorium;
    
    class AuditoriumDAO implements IDAO{
        
        private $auditoriumList = array ();


        public function Add($newAuditorium){
            $this->retrieveData();
            if ($this->chekExistence($newauditorium->getName())==0){
    
                $newauditorium->setId($this->nextId());
                array_push($this->auditoriumList, $newauditorium);
                $this->saveData();
            }else{
                echo  "<script> alert ('El auditorium que intenta agregar ya fue ingresado.'); </script>)";
                require_once(VIEWS_PATH."auditorium-add.php");
            }
           }
    
           public function chekExistence ($id)
           {
            $flag = 0;
            $this->retrieveData();
            $newList = array();
            foreach ($this->auditoriumList as $auditorium) {
                if($auditorium->getID() != $id){
                    array_push($newList, $auditorium);
                }else{
                    $flag = 1;
                }
            }
            $this->auditoriumList = $newList;
            return $flag;   
              
            }

        public function getAll(){
            $this->retrieveData();
            return $this->auditoriumList;
           }

        public function getAuditorium($id){
            $this->retrieveData();
            $auditorium = new Auditorium();
            foreach($this->auditorium$auditoriumList as $auditoriummaValue){
                if($auditoriummaValue->getId() == $id){
                     $auditorium = $auditoriummaValue;
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
    
            // $jsonContent = file_get_contents('../Data/beer.json');
            $jsonContent = file_get_contents($jsonPath);
            
            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();
    
            foreach ($arrayToDecode as $valueArray) {
                $auditorium = new Auditorium();
                $auditorium->setId($valueArray['id']);
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