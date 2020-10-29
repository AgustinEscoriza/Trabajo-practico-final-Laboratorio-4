<?php 
namespace Models;
 
class User{
	
	private $idUser;
	private $userName;
	private $userEmail;
	private $userPassword;
	private $userState;

	public function __construct(){
            
	}
	public function getIdUser (){
		return $this->idUser;
	}
	public function getUserName(){
		return $this->userName;
	}
	public function getUserEmail(){
		return $this->userEmail;
	}
	public function getUserPassword(){
		return $this->userPassword;
	}
	public function getUserState(){
		return $this->userState;
	}
	public function setIdUser ($idUser){
		$this->idUser = $idUser;
	}
	public function setUserName($userName){
		$this->userName = $userName;
	}
	public function setUserEmail($userEmail){
		$this->userEmail = $userEmail;
	}
	public function setUserPassword($userPassword){
		$this->userPassword = $userPassword;
	}
	public function setUserState($userState){
		$this->userState = $userState;
	}
	
}
 ?>