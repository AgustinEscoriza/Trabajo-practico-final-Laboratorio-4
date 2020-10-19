<?php 
namespace Models;
 
class User{
	
	private $userId;
	private $userName;
	private $userEmail;
	private $password;

	public function __construct(){
            
	}
	public function getUserId (){
		return $this->userId;
	}
	public function getUserName(){
		return $this->userName;
	}
	public function getUserEmail(){
		return $this->userEmail;
	}
	public function getPassword(){
		return $this->password;
	}
	public function setUserId ($userId){
		$this->userId = $userId;
	}
	public function setUserName($userName){
		$this->userName = $userName;
	}
	public function setUserEmail($userEmail){
		$this->userEmail = $userEmail;
	}
	public function setPassword($password){
		$this->password = $password;
	}
	
}
 ?>