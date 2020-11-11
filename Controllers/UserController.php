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
    use DAO\FunctionDAOmysql as FunctionDAO;

    class UserController{

        private $userProfile;
        //private $usersList=array();
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
            $this->movieDAO = new MovieDAO();
            $this->cinemaDAO = new CinemaDAO();
            $this->auditoriumDAO = new AuditoriumDAO();
            $this->functionDAO = new FunctionDAO();
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
               if($loggedUser->getUserPassword()==$userPassword && $loggedUser->getUserState()==1){
                   $this->setSession($loggedUser);
                   if($loggedUser->getUserRole() == '1'){
                    require_once(VIEWS_PATH."cinema-add.php");  
                   }else{
                    $this->billboardController->ShowFullList();
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
            $this->billboardController->ShowFullList();
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
                    $this->billboardController->ShowFullList();
                }else{
                    $this->billboardController->ShowFullList();
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

        public function getUsersList ()
        {
            $usersList = $this->userDAO->getAll();
            require_once(VIEWS_PATH."users-list.php");

        }

        public function showUserProfile ()
        {
            if(isset($_SESSION['userLogin'])){
                
                $ticketList = array();
                $ticketObject = array();
                $newTicketList = array();

                $userProfile = $_SESSION['userLogin'];
                $ticketList = $this->ticketDAO->getTicketsByUser($userProfile);
                if(!empty( $ticketList)){
                    foreach($ticketList as $ticket){
                        //var_dump($ticketList);
        
                        //$ticketObject["functionDate"] = strtotime($ticket->getFunction()->getDate()->format("Y-m-d"));
                        //$ticketObject["functionTime"] = strtotime($ticket->getFunction()->getTime()->format("H:i"));
                        $ticketObject["functionDate"] = $this->functionDAO->getByFunctionId($ticket->getFunction())->getDate();
                        $ticketObject["functionTime"] = $this->functionDAO->getByFunctionId($ticket->getFunction())->getTime();
                        $ticketObject["movieName"] = $this->movieDAO->GetMovieByFunctionId($ticket->getFunction())->getTitle();
                        $ticketObject["cinemaName"] = $this->cinemaDAO->GetCinemaByFunctionId($ticket->getFunction())->getName();
                        $ticketObject["auditoriumName"] = $this->auditoriumDAO->GetAuditoriumByFunctionId($ticket->getFunction())->getName();
                        
                        array_push($newTicketList,$ticketObject);
                    }
                }
                require_once(VIEWS_PATH."user-profile.php");
            }
        }

        public function orderTicketByMovie ($movieName)
        {
            if(isset($_SESSION['userLogin'])){
                
                $ticketList = array();
                $ticketObject = array();
                $newTicketList = array();

                $userProfile = $_SESSION['userLogin'];
                $ticketList = $this->ticketDAO->getTicketsByUser($userProfile);

                foreach($ticketList as $ticket){

                    if( $this->movieDAO->GetMovieByFunctionId($ticket->getFunction())->getTitle() == $movieName)
                    {
                        $ticketObject["functionDate"] = $this->functionDAO->getByFunctionId($ticket->getFunction())->getDate();
                        $ticketObject["functionTime"] = $this->functionDAO->getByFunctionId($ticket->getFunction())->getTime();
                        $ticketObject["movieName"] = $this->movieDAO->GetMovieByFunctionId($ticket->getFunction())->getTitle();
                        $ticketObject["cinemaName"] = $this->cinemaDAO->GetCinemaByFunctionId($ticket->getFunction())->getName();
                        $ticketObject["auditoriumName"] = $this->auditoriumDAO->GetAuditoriumByFunctionId($ticket->getFunction())->getName();
                        
                        array_push($newTicketList,$ticketObject);

                    } 
                }
                
                require_once(VIEWS_PATH."user-profile.php");
            }
        }

        public function orderTicketByDate ($date)
        {
            if(isset($_SESSION['userLogin'])){
                
                $ticketList = array();
                $ticketObject = array();
                $newTicketList = array();

                $userProfile = $_SESSION['userLogin'];
                $ticketList = $this->ticketDAO->getTicketsByUser($userProfile);

                foreach($ticketList as $ticket){

                    if( $this->functionDAO->getByFunctionId($ticket->getFunction())->getDate() == $date)
                    {
                        $ticketObject["functionDate"] = $this->functionDAO->getByFunctionId($ticket->getFunction())->getDate();
                        $ticketObject["functionTime"] = $this->functionDAO->getByFunctionId($ticket->getFunction())->getTime();
                        $ticketObject["movieName"] = $this->movieDAO->GetMovieByFunctionId($ticket->getFunction())->getTitle();
                        $ticketObject["cinemaName"] = $this->cinemaDAO->GetCinemaByFunctionId($ticket->getFunction())->getName();
                        $ticketObject["auditoriumName"] = $this->auditoriumDAO->GetAuditoriumByFunctionId($ticket->getFunction())->getName();
                        
                        array_push($newTicketList,$ticketObject);

                    } 
                }
                
                require_once(VIEWS_PATH."user-profile.php");
            }
        }

        public function showAdminDataView ()
        {
            require_once(VIEWS_PATH."admin-data.php");
        }

        public function showStatisticsView()
        {
            require_once(VIEWS_PATH."statistics-view.php");
        }

        public function deleteUser ($userId)
        {
            $this->userDAO->deleteUser($userId);
            $this->getUsersList();
        }
    }
    
?>