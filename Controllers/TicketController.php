<?php

    namespace Controllers;



    use DAO\CinemaDAOmysql as CinemaDAO;
    use DAO\MovieDAOmysql as MovieDAO;
    use DAO\FunctionDAOmysql as FunctionDAO;
    use DAO\AuditoriumDAOmysql as AuditoriumDAO;
    use DAO\TicketDAO;
    use Models\Functions;
    use Models\Ticket;
    use Controllers\BillboardController;


    class TicketController{

        private $ticketDAO;
        private $movieDAO;
        private $functionDAO;
        private $cinemaDAO;
        private $auditoriumDAO;
        private $billboardController;


        public function __construct(){

            $this->ticketDAO = new TicketDAO();
            $this->movieDAO = new MovieDAO();
            $this->functionDAO = new FunctionDAO();
            $this->cinemaDAO = new CinemaDAO();
            $this->auditoriumDAO = new AuditoriumDAO();
            $this->billboardController = new BillboardController();
        }

        public function buyTicketView($idFunction, $addMessage = ""){

            $movie = $this->movieDAO->GetMovieByFunctionId($idFunction);
            $cinema = $this->cinemaDAO->GetCinemaByFunctionId($idFunction);
            $auditorium = $this->auditoriumDAO->GetAuditoriumByFunctionId($idFunction);
            $function = $this->functionDAO->getByFunctionId($idFunction); 
            require_once(VIEWS_PATH."buy-Ticket-View.php");

        }



        public function setAndValidatePurchase($functionId,$ticketValue,$capacity,$quantity){
            
            $function = $this->functionDAO->getByFunctionId($functionId);
            $price = $ticketValue*$quantity;

            $price = $this->checkDiscount($price,$function->getDate(),$quantity);

            $user =  $_SESSION["userLogin"];

            $ticket = new Ticket();
            $ticket->setUser($user); 
            $ticket->setPrice($price); 
            $ticket->setFunction($function); 
            $ticket->setQuantity($quantity); 
            $ticket->setStatus(1);


            if($this->validateCapacity($function,$capacity,$ticket->getQuantity())){

                $_SESSION["tickets"] = $ticket; // dejo el ticket recien agregado en SESSION, este session es para el que no esta en el carro aun

                $this->showTotal($function,$ticket);
            }
            else{
                $this->buyTicketView($function->getId(),"The Show Is Sold Out");
            }
        }
        public function checkDiscount($price,$date,$quantity){
            $dayOfWeek = date('w', strtotime($date));
            $result = null;
            if($quantity >= 2 && ($dayOfWeek == 2 || $dayOfWeek == 3)){
                $result = $price*0.75;
            }
            else{
                $result = $price;
            }
            return $result;
        }

        public function validateCapacity(Functions $function,$capacity, $quantity){

            $result = false;

            $ticketsSold = $this->ticketDAO->getTicketsSoldByFunctionId($function->getId());

            $ticketsSold = $ticketsSold + $quantity;

            if($ticketsSold <= $capacity){
                $result = true;
            }
        
            return $result;
        }

        public function showTotal(Functions $function, Ticket $ticket){

            $movie = $this->movieDAO->GetMovieByFunctionId($function->getId());
            require_once(VIEWS_PATH . "addToCartView.php");
        }


        public function addToCart($confirmed = 0)
        {
            if ($confirmed == 1) {

                if (!isset($_SESSION['ticketsInCart'])) { // Si no tengo carro en session lo creo, tickets in Cart es donde tengo guardado el carro(conjunto de tickets)
                    $cart = array();
                    array_push($cart, $_SESSION['tickets']);
                    $_SESSION['ticketsInCart'] = $cart;
                } else {
                    array_push($_SESSION['ticketsInCart'], $_SESSION['tickets']); //sino le agrego el grupo nuevo al array
                }
                $this->billboardController->showFullList("Ticket added to cart succesfully");
            } else {
                $_SESSION['tickets'] = null;
                $this->billboardController->ShowFullList();
            }
        }

        public function showShoppingCart($addMessage = '') 
        {
            if (!isset($_SESSION['ticketsInCart'])) {
                $ticketList = array();
            } else {
                $ticketList = $_SESSION['ticketsInCart'];

            }
            require_once(VIEWS_PATH . "shoppingCart-View.php");
        }


        public function purchaseView(){

            $total = $this->getTotalPriceCart($_SESSION["ticketsInCart"]);

            require_once(VIEWS_PATH . "validation-card.php");

        }  

        public function getTotalPriceCart($ticketList){

            $result = 0;

            foreach($ticketList as $ticket){

                $result = $result + $ticket->getPrice();

            }

            return $result;
        }


        public function validateCreditCard($total, $cardOwner, $cardNumber, $expirationMonth, $expirationYear, $cvv){   // en este metodo cerramos la compra final, generamos el QR y lo mandamos por mail
            if($total != 0){

                $ticketList= $_SESSION['ticketsInCart'];

                foreach($ticketList as $ticket){
                    $ticket->setStatus(1);
                    $this->add($ticket);
                    $this->generateQR($ticket);
                }

                // mandarlo por mail iria aca, tendria que ser una funcion de este controller que se llame send ticket to email o sendEmail,

                unset($_SESSION['ticketsInCart']);
                unset($_SESSION['tickets']);

                $this->billboardController->showFullList("Purchase confirmed, the tickets will be send to your user Email");
            }
            else{
                $this->showShoppingCart("The cart is empty. Try adding it some tickets first!");
            }

        }


        public function removeShoppingCart($ticketId) // saca del shopping cart un ticket
        {
            if (!isset($_SESSION['ticketsInCart'])) {
                session_start();
            }
            $ticketList = $_SESSION['ticketsInCart'];
            $newTicketList = array();
            foreach ($ticketList as $value) {
                if ($value->getId() != $ticketId) {
                    array_push($newTicketList, $value);
                }
            }

            $_SESSION['ticketsInCart'] = $newTicketList;

            $this->showShoppingCart();
        }
        public function add(Ticket $ticket){ 

            $function = $ticket->getFunction();
            $this->ticketDAO->add($ticket);
            //$function->setTicketsSold($function->getTicketsSold() + $ticket->getQuantity());    // depende de si agregamos un atributo con la cantidad de tickets vendidos a las
            //$this->functionDAO->updateTicketsSold($function);                                   // funciones, sino DAO que traiga cantidad
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