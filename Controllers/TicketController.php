<?php

    namespace Controllers;



    use DAO\CinemaDAOmysql as CinemaDAO;
    use DAO\MovieDAOmysql as MovieDAO;
    use DAO\FunctionDAOmysql as FunctionDAO;
    use DAO\AuditoriumDAOmysql as AuditoriumDAO;
    use DAO\TicketDAO;
    use Models\Functions;
    use Models\Ticket;


    class TicketController{

        private $ticketDAO;
        private $movieDAO;
        private $functionDAO;
        private $cinemaDAO;
        private $auditoriumDAO;

        public function __construct(){

            $this->ticketDAO = new TicketDAO();
            $this->movieDAO = new MovieDAO();
            $this->functionDAO = new FunctionDAO();
            $this->cinemaDAO = new CinemaDAO();
            $this->auditoriumDAO = new AuditoriumDAO();
        }

        public function buyTicketView($idFunction, $addMessage = ""){

            $movie = $this->movieDAO->GetMovieByFunctionId($idFunction);
            $cinema = $this->cinemaDAO->GetCinemaByFunctionId($idFunction);
            $auditorium = $this->auditoriumDAO->GetAuditoriumByFunctionId($idFunction);
            $function = $this->functionDAO->getByFunctionId($idFunction); 
            require_once(VIEWS_PATH."buy-Ticket-View.php");

        }



        public function setAndValidatePurchase(Functions $function,$quantity){
            
            $function = $this->functionDAO->getByFunctionId($function->getId());
            $price = $function->getAuditorium()->getPrice(); // no va a andar porque no hay auditorium dentro de funcion, creo que hay que armar dao que devuelva auditorium de funcion

            $user =  $_SESSION["user"];

            $ticket = new Ticket();
            $ticket->setUser($user); 
            $ticket->setTotal($price); 
            $ticket->setFunction($function); 
            $ticket->setQuantity($quantity); 
            $ticket->setStatus(1);

            if($this->validateCapacity($movieShow,$ticket->getQuantity)){

                $_SESSION["tickets"] = $ticket;

                $this->showTotal($function,$ticket);
            }
            else{
                $this->buyTicketView($function->getId(),"The Show Is Sold Out");
            }
        }

        public function showTotal(Functions $function, Ticket $ticket){

            require_once(VIEWS_PATH . "addToCartView.php");
        }


        public function addToCart($confirmed = 0)
        {
            if ($confirmed == 1) {

                if (!isset($_SESSION['purchase'])) {
                    $purchase = array();
                    array_push($purchase, $_SESSION['tickets']);
                    $_SESSION['purchase'] = $purchase;
                } else {
                    array_push($_SESSION['purchase'], $_SESSION['tickets']);
                }
                $this->showShoppingCart("Ticket added to cart succesfully");
            } else {
                $_SESSION['tickets'] = null;
                require_once(VIEWS_PATH . "(alguna vista anterior)"); // no se que vista poner aca
            }
        }

        public function showShoppingCart($addMessage = '') 
        {
            if (!isset($_SESSION['purchase'])) {
                $ticketList = array();
            } else {
                $ticketList = $_SESSION['purchase'];
            }
            require_once(VIEWS_PATH . "shoppingCart-View.php");
        }

        public function removeShoppingCart($functionId) // saca del shopping cart todos los tickets de una funcion
        {
            if (!isset($_SESSION['purchase'])) {
                session_start();
            }
            $ticketList = $_SESSION['purchase'];
            $newTicketList = array();
            foreach ($ticketList as $value) {
                if ($value->getFunction()->getId() != $functionId) {
                    array_push($newTicketList, $value);
                }
            }

            $_SESSION['purchase'] = $newTicketList;

            $this->showShoppingCart();
        }
        public function add(Ticket $ticket){ 

            $function = $ticket->getFunction();
            $this->ticketDAO->add($ticket);
            $function->setTicketsSold($function->getTicketsSold() + $ticket->getQuantity());    // depende de si agregamos un atributo con la cantidad de tickets vendidos a las
            $this->functionDAO->updateTicketsSold($function);                                   // funciones, sino DAO que traiga cantidad
        }

        public function GenerateQR(/*$userName, $cinemaName, $auditoriumName, $functionDate, $ticketsPurchased*/)
        {             
             $userName ='Dami';
             $cinemaName='Ambassador';
             $auditoriumName ='Sala Bolt';
             $functionDate ='Jueves 3';
             $ticketsPurchased= '2';
            
            require_once(VIEWS_PATH."QRCode-View.php");
        }
    }

?>