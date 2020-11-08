<?php
    namespace Controllers;

    require_once  'vendor/autoload.php';

    //use DAO\UserDAO as UserDAO;
    use DAO\UserDAOmysql as UserDAOmysql;
    use Models\User as User;
    use Facebook\Facebook as Facebook;
    use Controllers\BillboardController as BillboardController;
    use DAO\TicketDAO as TicketDAO;
    use DAO\CinemaDAOmysql as CinemaDAO;
    use DAO\MovieDAOmysql as MovieDAO;
    use DAO\AuditoriumDAOmysql as AuditoriumDAO;

    class UserController{

        private $userProfile;
        private $userDAO;
        private $billboardController;
        private $ticketDAO;
        private $movieDAO;
        private $cinemaDAO;
        private $auditoriumDAO;

        public function __construct()
        {
            $this->userProfile = new User ();
            $this->userDAO = new userDAOmysql();
            $this->billboardController = new BillboardController();
            $this->ticketDAO = new TicketDAO();
            $this->movietDAO = new MovieDAO();
            $this->cinemaDAO = new CinemaDAO();
            $this->auditoriumDAO = new AuditoriumDAO();
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
            unset($_SESSION['userGuest']);
            unset($_SESSION['userLogin']);
            $_SESSION['userLogin']=$user;
        }

        public function login ($userName, $userPassword)
        {

            $loggedUser= $this->userDAO->read($userName);

             if($loggedUser){
               if($loggedUser->getUserPassword()==$userPassword){
                   $this->setSession($loggedUser);
                   if($loggedUser->getUserRole() == '1'){
                    require_once(VIEWS_PATH."cinema-add.php");  
                   }else{
                    require_once(VIEWS_PATH."fullBillboard-View.php");
                   }     
               }else{
               $message='Verifique que los datos ingresados sean correctos';
               return $this->showLoginView($message);
               }
             }else{
                $message='Verifique que los datos ingresados sean correctos'; 
                return $this->showLoginView($message);
             }
        }
        
       function AddFBuser()
       {
           $user = new User ();
           $user->setUserName( $_SESSION['fbUser']['fbName']);
           $user->setUserEmail( $_SESSION['fbUser']['fbEmail']);
           $user->setUserPassword( $_SESSION['fbUser']['fbId']);
           $user->setfbAccesToken( $_SESSION['fbUser']['fbAccessToken']);

           $this->userDAO->AddFBuser($user);
       }
        

        public function fbLogin ()
        {
            //if(isset($_SESSION['FBRLH_state'])){
               // require_once(VIEWS_PATH."movies-list.php");
            //}

            $fb = new Facebook([
                'app_id' => '859666478172573',
                'app_secret' => 'c834072c227ca866271ab41e1c572bee',
                'default_graph_version' => 'v8.0',
                ]);
              
              $helper = $fb->getRedirectLoginHelper();
              var_dump($helper);
              
              $permissions = ['email']; 
              $redirectURL = "http://".$_SERVER['SERVER_NAME']."/moviepassviernes/Controllers/FBController.php";
              $loginUrl = $helper->getLoginUrl($redirectURL, $permissions);
              
              //echo '<a href="' . $loginUrl . '">Log in con Facebook!</a>';
              //header('Location: [http://www.mipagina.com/%27) http://www.mipagina.com/')];
              
              header("Location: ".$loginUrl);
              exit;
              //var_dump($loginUrl);
              //$this->AddFBuser();
                  
        }

        
        public function logout ()
        {
            //if (session_status( )== PHP_SESSION_NONE){
             //   session_start();
              //  session_destroy();
           // }else{
              //  session_destroy();
            //}
            if(isset($_SESSION['userLogin'])){
                unset($_SESSION['userLogin']);
            }
            require_once(VIEWS_PATH."fullBillboard-View.php");
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
            //if (isset($_SESSION["userLogin"])) session_unset();
            //if (isset($_SESSION["fbUser"])) session_destroy();
            //$_SESSION["userLogin"] = null;
            require_once(VIEWS_PATH."user-login.php");
        }

        public function showRegisterView($message=""){
            require_once(VIEWS_PATH."user-register.php");
        }

        public function userRole ()
        {
            if(isset($_SESSION["userLogin"])){
                if($_SESSION['userLogin']->getUserRole()==1){
                    require_once(VIEWS_PATH."cinema-add.php");
                }elseif($_SESSION['userLogin']->getUserRole()==2){
                    require_once(VIEWS_PATH."billboard-View.php");
                }else{
                    require_once(VIEWS_PATH."billboard-View.php");
                }
            }
        }

        public function userCheck ()
        {
            //unset($_SESSION["userLogin"]);
            if(!isset($_SESSION["userGuest"])){
                $userGuest = new User();
                $userGuest->setUserName("guest");
                $userGuest->setUserEmail("guest");
                $userGuest->setUserPassword("guest");
                $userGuest->setUserState(1);
                $userGuest->setUserRole(3);
                $this->setSession($userGuest);  
                
                //require_once(VIEWS_PATH."user-login.php");
                //echo  "<script> alert ('debe registrase'); </script>";
            }

        }

        public function showUserProfile ()
        {
            if(isset($_SESSION['userLogin'])){
                
                $ticketList = array();
                $ticketObject = array();
                $newTicketList = array();

                $this->userProfile = $_SESSION['userLogin'];
                $ticketList = $this->ticketDAO->getTicketsByUser($userProfile);
                
                foreach($ticketList as $ticket){
                    
                    $ticketObject["functionDate"] = $ticket->getFunction()->getDate();
                    $ticketObject["functionTime"] = $ticket->getFunction()->getTime();
                    $ticketObject["movieName"] = $this->movieDAO->GetMovieByFunctionId($ticket->getFunction()->getId())->getTitle();
                    $ticketObject["cinemaName"] = $this->cinemaDAO->GetCinemaByFunctionId($ticket->getFunction()->getId())->getName();
                    $ticketObject["auditoriumName"] = $this->auditoriumDAO->GetAuditoriumByFunctionId($ticket->getFunction()->getId())->getName();
                    
                    array_push($newTicketList,$ticketObject);
                }
                require_once(VIEWS_PATH."user-profile.php");
            }
        }
    }
    
?>