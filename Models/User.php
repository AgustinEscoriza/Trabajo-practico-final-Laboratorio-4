<?php 
namespace Models;
 
class User{
	
	private $userName;
	private $password;

	public function __construct(){
            
	}

	public function getUserName(){
		return $this->userName;
	}
	public function getPassword(){
		return $this->password;
	}
	public function setUserName($userName){
		$this->userName = $userName;
	}
	public function setPassword($password){
		$this->password = $password;
	}
	
}
 ?>