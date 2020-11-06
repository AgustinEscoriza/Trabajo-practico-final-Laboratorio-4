<?php 
namespace Models;
 
class User{
	
	private $idUser;
	private $userName;
	private $userEmail;
	private $userPassword;
	private $userState;
	private $userRole;
	private $fbId;
	private $fbAccesToken;

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
	public function getUserRole(){
		return $this->userRole;
	}
	public function getfbfbId(){
		return $this->fbId;
	}
	public function getfbAccesToken(){
		return $this->fbAccesToken;
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
	public function setUserRole($userSRole){
		$this->userRole = $userRole;
	}
	public function setfbId($fbId){
		$this->fbId = $fbId;
	}
	public function setfbAccesToken($fbAccesToken){
		$this->fbAccesToken = $fbAccesToken;
	}
	
}
 ?>