<?php
    require_once(ROOT.'QRGenerator/qrlib.php');
    require_once('Config\Autoload.php');
    require_once("nav.php");
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
            if (!file_exists($savingQRFilePath)) {
                QRcode::png($QRCodeText, $savingQRFilePath);
                echo ' <div class="movieSelect" style="display:block; align-items: center; text-align: center; max-width:500">
                <h5 style="color:white; background:rgba(0, 0, 0, 0.7); widht:50;"> QR Code Generado con Exito </h5>
                </div>';
                echo '<hr />';
            } else {
                echo '<div class="movieSelect" style="display:block; align-items: center; text-align: center; max-width:500">
                <h5 style="color:white; background:rgba(0, 0, 0, 0.7); widht:50;"> Recuperar QR Code </h5>
                </div>';
                echo '<hr />';
            }

?>

<main class = "py-5">
    <section class = "mb-5">
        <div class = "container">
            <table class = "table">
                <thead>
                    <tr>                        
                        <th style = "width: 15%;">Usuario</th>
                        <th style = "width: 10%;">Cinema</th>
                        <th style = "width: 10%;">Auditorium</th>
                        <th style = "width: 10%;">Date</th>
                        <th style = "width: 10%;">Tickets</th>
                        <th style = "width: 15%;"> </th>
                    </tr>
                </thead>
                <tbody>                        
                        <td style="color:white; background:rgba(0, 0, 0, 0.7); widht:50"> <?php echo $userName ?> </td>
                        <td style="color:white; background:rgba(0, 0, 0, 0.7); widht:50"> <?php echo $cinemaName?> </td>
                        <td style="color:white; background:rgba(0, 0, 0, 0.7); widht:50"> <?php echo $auditoriumName?> </td>
                        <td style="color:white; background:rgba(0, 0, 0, 0.7); widht:50"> <?php echo $functionDate  ?> </td>
                        <td style="color:white; background:rgba(0, 0, 0, 0.7); widht:50"> <?php echo $ticketsPurchased ?> </td>
                        <td style="color:white; background:rgba(0, 0, 0, 0.7); widht:50"> <img src="<?php echo $newQRFilePath ?>" > </td>
                <tbody>
            </table>

            <form action="<?php echo FRONT_ROOT ?>Billboard/showFullList" method="post" class="add-form bg-light-alpha p-5">

                <button class="btn btn-success" style="text-align:center;">Volver a La Cartelera</button>
            </form>

            <?php
            if (isset($addMessage) && $addMessage != "") {
                echo "<div class='alert alert-primary' role='alert'> $message </div>";
            }
            ?>
        </div>
    </section>
</main>