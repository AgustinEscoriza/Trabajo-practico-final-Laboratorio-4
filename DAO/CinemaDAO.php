<?php
    namespace DAO;

    use DAO\ICinemaDAO as ICinemaDAO;
    use Models\Cinema as Cinema;    

    class CinemaDAO implements ICinemaDAO
    { 
       private $cinemaList = array ();

       /*public function Add($newCinema){
        $this->retrieveData();
        $newCinema->setId($this->nextId());
		array_push($this->cinemaList, $newCinema);
		$this->saveData();
       }*/

       public function Add($newCinema){
        $this->retrieveData();
        if ($this->chekExistence($newCinema->getName())==0){

            $newCinema->setId($this->nextId());
		    array_push($this->cinemaList, $newCinema);
            $this->saveData();
            $addMessage = "El cinema ha sido ingresado exitosamente";
        }else{
           // echo  "<script> alert ('El cinema que intenta agregar ya fue ingresado.'); </script>)";
            $addMessage = "El cinema que intenta agregar ya fue ingresado";
            //require_once(VIEWS_PATH."cinema-add.php");  
        }
        return $addMessage;
       }

       public function chekExistence ($name)
       {
        $flag = 0;
        $this->retrieveData();
        $newList = array();
        foreach ($this->cinemaList as $cinema) {
			if($cinema->getName() != $name){
				array_push($newList, $cinema);
			}else{
                $flag = 1;
            }
        }
        $this->cinemaList = $newList;
        return $flag;   
          
        }
       
       public function getAll(){
        $this->retrieveData();
		return $this->cinemaList;
       }

       public function getCinema($id){
           $this->retrieveData();
           $cinema = new Cinema();
           foreach($this->cinemaList as $cinemaValue){
               if($cinemaValue->getId() == $id){
                    $cinema = $cinemaValue;
               }
           }

           return $cinema;
       }

       public function nextId(){
        $id = 0;
        $this->retrieveData();

        foreach($this->cinemaList as $value){
            $id = $value->getId();
        }

        return $id + 1;
        }      
       public function delete($id){
        
        $this->retrieveData();

        foreach ($this->cinemaList as $cinemaValue) {

            if ($cinemaValue->getId() == $id) {
                $key = array_search($cinemaValue, $this->cinemaList);
                unset($this->cinemaList[$key]);
            }
        }
        $this->SaveData();
       }
       
       public function saveData(){
		$arrayToEncode = array();

		foreach ($this->cinemaList as $cinema) {
            $valueArray['id'] = $cinema->getId();
			$valueArray['name'] = $cinema->getName();
			$valueArray['adress'] = $cinema->getAdress();

			array_push($arrayToEncode, $valueArray);

		}
		$jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
		file_put_contents(dirname(__DIR__) .'/Data/cinema.json', $jsonContent);
        }
        
        public function retrieveData(){
            $this->cinemaList = array();
    
            $jsonPath = $this->GetJsonFilePath();
    
            // $jsonContent = file_get_contents('../Data/beer.json');
            $jsonContent = file_get_contents($jsonPath);
            
            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();
    
            foreach ($arrayToDecode as $valueArray) {
                $cinema = new Cinema();
                $cinema->setId($valueArray['id']);
			    $cinema->setName($valueArray['name']);
			    $cinema->setAdress($valueArray['adress']);
                
                array_push($this->cinemaList, $cinema);
            }
        }

        function GetJsonFilePath(){

            $initialPath = "Data/cinema.json";
            if(file_exists($initialPath)){
                $jsonFilePath = $initialPath;
            }else{
                $jsonFilePath = "../".$initialPath;
            }
    
            return $jsonFilePath;
        }
    }
?>