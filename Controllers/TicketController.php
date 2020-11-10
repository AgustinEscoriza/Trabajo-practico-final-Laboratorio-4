<?php

    namespace Controllers;

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception as MailerException;

    use DAO\CinemaDAOmysql as CinemaDAO;
    use DAO\MovieDAOmysql as MovieDAO;
    use DAO\FunctionDAOmysql as FunctionDAO;
    use DAO\AuditoriumDAOmysql as AuditoriumDAO;
    use DAO\TicketDAO;
    use Models\Functions;
    use QRcode;
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
            $ticket->setFunction($function->getId()); 
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
        public function removeFromCart($ticketId){
            $key = 0;
            if(isset($_SESSION['ticketsInCart'])){
                foreach($_SESSION['ticketsInCart'] as $ticket){
                    
                    if($ticketId == $ticket->getId()){    // no tengo la id cargada no va a andar, la cargo en el add de la bdd
                        
                    }
                    $key++;
                }
            }
        }

        public function showShoppingCart($addMessage = '') 
        {
    
            if (!isset($_SESSION['ticketsInCart'])) {
                $ticketList = array();
            } else {
                $ticketList = $_SESSION['ticketsInCart'];
                $newTicketList = array();
                foreach($ticketList as $ticket){

                    $ticketObject["functionDate"]   = $this->functionDAO->getByFunctionId($ticket->getFunction())->getDate();
                    $ticketObject["functionTime"]   = $this->functionDAO->getByFunctionId($ticket->getFunction())->getTime();
                    $ticketObject["price"]          = $ticket->getPrice();
                    $ticketObject["movieName"]      = $this->movieDAO->GetMovieByFunctionId($ticket->getFunction())->getTitle();
                    $ticketObject["cinemaName"]     = $this->cinemaDAO->GetCinemaByFunctionId($ticket->getFunction())->getName();
                    $ticketObject["auditoriumName"] = $this->auditoriumDAO->GetAuditoriumByFunctionId($ticket->getFunction())->getName();
                        
                    array_push($newTicketList,$ticketObject);
                }
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
                $ticketUser= $_SESSION["userLogin"];
                

                foreach($ticketList as $ticket){    //movi los ticket Cinema, Auditorium y function adentro del foreach asi acepta entradas para distintos cines

                    $ticketCinema = $this->cinemaDAO->GetCinemaByFunctionId($ticket->getFunction());
                    $ticketAuditorium = $this->auditoriumDAO->GetAuditoriumByFunctionId($ticket->getFunction());
                    $ticketFunction = $this->functionDAO->getByFunctionId($ticket->getFunction()); 
                    $ticket->setStatus(1);
                    $qr = $this->generateQR($ticketUser->getUserName(),$ticketCinema->getName(),$ticketAuditorium->getName(),$ticketFunction->getDate(),$ticket->getQuantity());
                    $ticket->setQr($qr);
                    $this->add($ticket);
                }

                $this->sendEmail($ticketList);
                $this->showQrCode($ticketList,$ticketUser);

                unset($_SESSION['ticketsInCart']);
                unset($_SESSION['tickets']);
                unset($_SESSION['qrTickets']);

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

        public function GenerateQR($userName, $cinemaName, $auditoriumName, $functionDate, $ticketsPurchased) // movi este codigo para aca porque necesito que me retorne el Qr para cargarlo en el mail
        {   
            require_once(ROOT.'QRGenerator/qrlib.php');
            
            //require_once(ROOT.'../QRGenerator/qrlib.php');

            //agrego todo el texto que va a contener el QR
            $QRCodeText =   'User Name: '.$userName.
                            ' - Cinema: '.$cinemaName.
                            ' - Auditorium: '.$auditoriumName.
                            ' - Date: '.$functionDate.
                            ' - Tickets: '.$ticketsPurchased;
                    
            //el nombre del archivo se genera mediante md5 hash en base al texto de lqr
            $fileName = 'Ticket_Purchase_'.md5($QRCodeText).'.png';
                    
            //seteo la direccion donde se almacena el QR, y la ruta de lectura
            $savingQRFilePath = IMG_PATHSAVE.$fileName;
            $newQRFilePath = IMG_PATH.$fileName;
                    
            // generating
        //   if (!file_exists($savingQRFilePath)) {
        //       QRcode::png($QRCodeText, $savingQRFilePath);
        //       echo ' <div class="movieSelect" style="display:block; align-items: center; text-align: center; max-width:500">
        //       <h5 style="color:white; background:rgba(0, 0, 0, 0.7); widht:50;"> QR Code Generado con Exito </h5>
        //       </div>';
        //   echo '<hr />';
        //   } else {
        //               echo '<div class="movieSelect" style="display:block; align-items: center; text-align: center; max-width:500">
        //               <h5 style="color:white; background:rgba(0, 0, 0, 0.7); widht:50;"> Recuperar QR Code </h5>
        //               </div>';
        //               echo '<hr />';
        //           }
            QRcode::png($QRCodeText, $savingQRFilePath);


            return $newQRFilePath;
        }
        public function showQRCode($ticketList, $ticketUser){
            
            foreach($ticketList as $ticket){ 

                $ticketObject["cinemaName"]         = $this->cinemaDAO->GetCinemaByFunctionId($ticket->getFunction())->getName();
                $ticketObject["auditoriumName"]     = $this->auditoriumDAO->GetAuditoriumByFunctionId($ticket->getFunction())->getName();
                $ticketObject["userName"]           = $ticketUser->getUserName();
                $ticketObject["movieName"]          = $this->movieDAO->GetMovieByFunctionId($ticket->getFunction())->getTitle();
                $ticketObject["functionDate"]       = $this->functionDAO->getByFunctionId($ticket->getFunction())->getDate();
                $ticketObject["ticketsPurchased"]   = $ticket->getQuantity();
                $ticketObject["qr"]                 = $ticket->getQr(); 
                array_push($newTicketList,$ticketObject);
            }

            require_once(VIEWS_PATH."QRCode-View.php");

        }

        public function sendEmail($ticketList){
            //moviepasslaboratorio4@gmail.com
            //laboratorio4     cuenta y password de gmail

            require_once("Data/PHPMailer/src/Exception.php");
            require_once("Data/PHPMailer/src/PHPMailer.php");
            require_once("Data/PHPMailer/src/SMTP.php");
            $userEmail = $_SESSION['userLogin']->getUserEmail();
            $qrsToSend = $ticketList;

            $listToSend = array();
            $counter = 0;

            foreach ($ticketList as $ticket){

                $fileToSend = "Data/qrs/email".$counter.".png"; // probablemente este mal hay que poner el file donde este el Qr pero no se donde estan, creo que es la linea 231
                fopen($fileToSend, "w");
                $qr = $ticket->getQr();
                $img = file_get_contents("$qr"); //"Data/qrs/qr1.png");
                file_put_contents($fileToSend, $img);
                $counter++;

                array_push($listToSend, $fileToSend);

            }

            $mail = new PHPMailer(true);

            try {
                //Server settings
                $mail->SMTPDebug = 0;                      // Enable verbose debug output
                $mail->isSMTP();                                            // Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = 'moviepasslaboratorio4@gmail.com';                     // SMTP username
                $mail->Password   = 'laboratorio4';                               // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
    
                //Recipients
                $mail->setFrom('moviepasslabiv@gmail.com', 'MoviePass');
                $mail->addAddress($userEmail, 'MoviePass');     // Add a recipient
    
                // Attachments
                foreach ($listToSend as $file) {
                    $mail->addAttachment($file);
                }
    
    
                // Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = 'MoviePass!';
                $mail->Body    = 'Thanks for buying your tickets in <b>MoviePass</b>';
                $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    
                $mail->send();
            } catch (MailerException $e) {
                $this->showShoppingCart("Tickets could not be sent to the mail");
            }
            
        }

        public function getTicketsByCinema($cinemaName){

            $ticketList = $this->ticketDAO->getAll();
            $newTicketList= array();
            $ticketObjects= array();
            $total=0;

            foreach($ticketList as $ticket){
                if($this->cinemaDAO->GetCinemaByFunctionId($ticket->getFunction())->getName()==$cinemaName){

                    $ticketObject["movieName"] = $this->movieDAO->GetMovieByFunctionId($ticket->getFunction())->getTitle();
                    $ticketObject["cinemaName"] = $this->cinemaDAO->GetCinemaByFunctionId($ticket->getFunction())->getName();
                    $ticketObject["functionId"] = $this->functionDAO->getByFunctionId($ticket->getFunction());
                    $ticketObject["quantity"] = $ticket->getQuantity();
                    $ticketObject["price"] = $ticket->getPrice();
                    $total = $total + $ticket->getPrice();
                    
                    
                    array_push($newTicketList,$ticketObject);
                }   
            }
           
            require_once(VIEWS_PATH."statistics-view.php");
        }
        
    }

?>