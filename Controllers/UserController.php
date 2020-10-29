<?php
    namespace Controllers;

    //use DAO\UserDAO as UserDAO;
    use DAO\UserDAOmysql as UserDAOmysql;
    use Models\User as User;

    class UserController{

        private $userDAO;

        public function __construct()
        {

            $this->userDAO = new userDAOmysql();
        }

        public function Add($userName, $userEmail, $password)
        {
            $user = new User();
            $user->setUserName($userName);
            $user->setUserEmail($userEmail);
            $user->setUserPassword($password);

            $this->showRegisterView($this->userDAO->Add($user));

        }

        public function setSession ($user)
        {
            $_SESSION['userLogin']=$user;
        }

        public function login ($userName, $userPassword)
        {

            $loggedUser= $this->userDAO->read($userName);

             if($loggedUser){
               if($loggedUser->getUserPassword()==$userPassword){
                   $this->setSession($loggedUser);
                   //return $loggedUser;
                   require_once(VIEWS_PATH."cinema-add.php");
               }else{
               $message='Verifique que los datos ingresados sean correctos';
               return $this->showLoginView($message);
               }
             }
        }

        public function logout ()
        {
            if (session_status( )== PHP_SESSION_NONE){
                session_start();
                session_destroy();
            }else{
                session_destroy();
            }
            $this->showLoginView();
        }
        
        /*$userLoginName=$userName;
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
        }*/  

        public function showLoginView($message=""){
            require_once(VIEWS_PATH."user-login.php");
        }

        public function showRegisterView($message=""){
            require_once(VIEWS_PATH."user-register.php");
        }
    }
    
?>