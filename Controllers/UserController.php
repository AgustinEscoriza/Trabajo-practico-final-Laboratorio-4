<?php
    namespace Controllers;

    use DAO\userDAO as UserDAO;
    use Models\User as User;

    class UserController{

        private $userDAO;

        public function __construct(){

            $this->userDAO = new userDAO();
        }

        public function Add($userName, $userEmail, $password)
        {
            $user = new User();
            $user->setUserName($userName);
            $user->setUserEmail($userEmail);
            $user->setPassword($password);

            $this->showRegisterView($this->userDAO->Add($user));

        }

        public function login ($userName, $password){

        $loggedUser=NULL;
        
        $userLoginName=$userName;
        $userLoginPass=$password;

        foreach($this->userDAO->getAll() as $user)

		     if($userLoginName == ($user->getUserName())){
			     if( $userLoginPass == ($user->getPassword())){
                  $loggedUser = new User();
                  $loggedUser->setUserName($userLoginName);
                  $loggedUser->setPassword($userLoginPass);
			     }
		     }
	      
             
        if($loggedUser != NULL){
	     //session_start();
	     $_SESSION['loggedUser'] = $loggedUser;
         //header("location:../cinema-add.php");
         require_once(VIEWS_PATH."cinema-add.php");
	
        }else{
            $message='Verifique que los datos ingresados sean correctos';
            //header("location:../cinema-add.php?error=true");
          return $this->showLoginView($message);
        }
        }  

        public function showLoginView($message=""){
            session_destroy();
            require_once(VIEWS_PATH."user-login.php");
        }

        public function showRegisterView($message=""){
            session_destroy();
            require_once(VIEWS_PATH."user-register.php");
        }
    }
    
?>