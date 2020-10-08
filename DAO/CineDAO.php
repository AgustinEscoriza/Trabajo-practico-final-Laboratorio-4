<?php
    namespace DAO;

    use DAO\ICineDAO as ICineDAO;
    use Models\Cine as Cine;    

    class CineDAO implements ICineDAO
    { 
       private $cineList = array ();

       public function Add(Cine $newCine){
        $this->retrieveData();
        $newCine->setId($this->nextId());
		array_push($this->cineList, $newCine);
		$this->saveData();
       }
       
       public function getAll(){
        $this->retrieveData();
		return $this->cineList;
       }

       public function nextId(){
        $id = 0;
        $this->retrieveData();

        foreach($this->cineList as $value){
            $id = $value->getId();
        }

        return $id + 1;
        }      
       public function delete($id){
		$this->retrieveData();
		$newList = array();
		foreach ($this->cineList as $cine) {
			if($cine->getId() != $id){
				array_push($newList, $cine);
			}
		}

		$this->cineList = $newList;
		$this->saveData();
       }
       
       public function saveData(){
		$arrayToEncode = array();

		foreach ($this->cineList as $cine) {
            $valueArray['id'] = $cine->getId();
			$valueArray['name'] = $cine->getName();
			$valueArray['adress'] = $cine->getAdress();
			$valueArray['capacity'] = $cine->getCapacity();
			$valueArray['ticketValue'] = $cine->getTicketValue();

			array_push($arrayToEncode, $valueArray);

		}
		$jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
		file_put_contents(dirname(__DIR__) .'/Data/cine.json', $jsonContent);
        }
        
        public function retrieveData(){
            $this->cineList = array();
    
            $jsonPath = $this->GetJsonFilePath();
    
            // $jsonContent = file_get_contents('../Data/beer.json');
            $jsonContent = file_get_contents($jsonPath);
            
            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();
    
            foreach ($arrayToDecode as $valueArray) {
                $cine = new Cine();
                $cine->setId($valueArray['id']);
			    $cine->setName($valueArray['name']);
			    $cine->setAdress($valueArray['adress']);
			    $cine->setCapacity($valueArray['capacity']);
			    $cine->setTicketValue($valueArray['ticketValue']);
                
                array_push($this->cineList, $cine);
            }
        }

        function GetJsonFilePath(){

            $initialPath = "Data/cine.json";
            if(file_exists($initialPath)){
                $jsonFilePath = $initialPath;
            }else{
                $jsonFilePath = "../".$initialPath;
            }
    
            return $jsonFilePath;
        }
    }
?>