<?php

    namespace Controllers;

    use DAO\CinemaDAOmysql as CinemaDAO;
    use DAO\MovieDAOmysql as MovieDAO;
    use DAO\FunctionDAOmysql as FunctionDAO;
    use DAO\TicketDAO;
    use Models\Functions;
    use Models\Ticket;


    class TicketController{

        private $ticketDAO;
        private $movieDAO;
        private $functionDAO;
        private $cinemaDAO;

        public function __construct(){

            $this->ticketDAO = new TicketDAO();
            $this->movieDAO = new MovieDAO();
            $this->functionDAO = new FunctionDAO();
            $this->cinemaDAO = new MovieDAO();
        }

        public function buyTicketView($functionId, $addMessage = ""){

            $function = $this->functionDAO->getByFunctionId($functionId); // falta armar esta funcion en el dao, o puedo traer funciones enteras tal vez

            require_once(VIEWS_PATH . "buy-Ticket-View.php");

        }



        public setAndValidatePurchase($functionId,$quantity){
            
            $function = $this->functionDAO->getByFunctionId($functionId);
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

        public showTotal(Function $function, Ticket $ticket){

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
            $this->functionDAO->updateTicketsSold($function);                                   // funciones
        }


    }

?>