<?php
    namespace Controllers;

    use Models\User as User;

    class UserController{


        public function login ($userName, $password){
        
        $userLoginName=$userName;
        $userLoginPass=$password;

		     if($userLoginName == "admin"){
			     if( $userLoginPass == "123456"){
                  $loggedUser = new User();
                  $loggedUser->setUserName($userLoginName);
                  $loggedUser->setPassword($userLoginPass);
			     }
		     }
	      
             
        if($loggedUser != NULL){
	     //session_start();
	     $_SESSION['loggedUser'] = $loggedUser;
         //header("location:../cine-add.php");
         require_once(VIEWS_PATH."cine-add.php");
	
        }else{
	      echo "<script> if(confirm('Verifique que los datos ingresados sean correctos'));";
	      echo "window.location = '../index.php';
		  </script>";
        }
        }  

        /*private function login (){
            if($_POST){
                if($_POST['do'] == 'continuar'){
                    header("location:../cine-add.php");
                }else{
                    session_start();
                    session_destroy();
                    header("location:../index.php");
                }
            }
    
        }*/
    }
?>