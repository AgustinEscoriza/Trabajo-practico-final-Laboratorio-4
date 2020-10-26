<?php
    namespace DAO;

    use DAO\IUserDAO as IUserDAO;
    use Models\User as User;    

    class UserDAO implements IUserDAO
    { 
       private $usersList = array ();

       public function Add($newUser){
        $this->retrieveData();
        if ($this->chekUserExistence($newUser->getUserName())==0){

            $newUser->setUserId($this->nextId());
		    array_push($this->usersList, $newUser);
            $this->saveData();
            $addMessage = "El usuario ha sido creado exitosamente";
        }else{
            $addMessage = "El nombre de usuario que intenta agregar esta en uso, elija uno distinto";        
        }

        return $addMessage;
       }

       public function chekUserExistence ($userName)
       {
        $flag = 0;
        $this->retrieveData();
        $newList = array();
        foreach ($this->usersList as $user) {
			if($user->getUserName() != $userName){
				array_push($newList, $user);
			}else{
                $flag = 1;
                break;
            }
        }
        if($flag==0){
          $this->usersList = $newList;
        }
     
        return $flag;     
        }
       
       public function getAll(){
        $this->retrieveData();
		return $this->usersList;
       }

       public function getUser($userId){
           $this->retrieveData();
           $user = new User();
           foreach($this->usersList as $userValue){
               if($userValue->getUserId() == $userId){
                    $user = $userValue;
               }
           }

           return $user;
       }

       public function nextId(){
        $id = 0;
        $this->retrieveData();

        foreach($this->usersList as $value){
            $id = $value->getUserId();
        }

        return $id + 1;
        }      
       public function delete($userId){
        
        $this->retrieveData();

        foreach ($this->usersList as $userValue) {

            if ($userValue->getUserId() == $userId) {
                $key = array_search($userValue, $this->usersList);
                unset($this->usersList[$key]);
            }
        }
        $this->SaveData();
       }
       
       public function saveData(){
		$arrayToEncode = array();

		foreach ($this->usersList as $user) {
            $valueArray['userId'] = $user->getUserId();
			$valueArray['userName'] = $user->getUserName();
            $valueArray['userEmail'] = $user->getUserEmail();
            $valueArray['password'] = $user->getPassword();

			array_push($arrayToEncode, $valueArray);

		}
		$jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
		file_put_contents(dirname(__DIR__) .'/Data/user.json', $jsonContent);
        }
        
        public function retrieveData(){
            $this->usersList = array();
    
            $jsonPath = $this->GetJsonFilePath();
    
            $jsonContent = file_get_contents($jsonPath);
            
            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();
    
            foreach ($arrayToDecode as $valueArray) {
                $user = new User();
                $user->setUserId($valueArray['userId']);
			    $user->setUserName($valueArray['userName']);
			    $user->setUserEmail($valueArray['userEmail']);
			    $user->setPassword($valueArray['password']);
                
                array_push($this->usersList, $user);
            }
        }

        function GetJsonFilePath(){

            $initialPath = "Data/user.json";
            if(file_exists($initialPath)){
                $jsonFilePath = $initialPath;
            }else{
                $jsonFilePath = "../".$initialPath;
            }
    
            return $jsonFilePath;
        }
    }
?>