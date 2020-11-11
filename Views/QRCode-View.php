<?php
    require_once('Config\Autoload.php');
    require_once("nav.php");

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
                        <th style = "width: 10%;">Time</th>
                        <th style = "width: 10%;">Tickets</th>
                        <th style = "width: 10%;">Movie</th>
                        <th style = "width: 15%;"> </th>
                    </tr>
                </thead>
                <tbody>
                <?php
                if(!empty($newTicketList)) {
                    foreach($newTicketList as $ticketObject){ 
                                  
                ?>
                    <tr>                        
                        <td style="color:white; background:rgba(0, 0, 0, 0.7); widht:50"> <?php echo $ticketObject["userName"] ?> </td>
                        <td style="color:white; background:rgba(0, 0, 0, 0.7); widht:50"> <?php echo $ticketObject["cinemaName"]  ?> </td>
                        <td style="color:white; background:rgba(0, 0, 0, 0.7); widht:50"> <?php echo $ticketObject["auditoriumName"]?> </td>
                        <td style="color:white; background:rgba(0, 0, 0, 0.7); widht:50"> <?php echo $ticketObject["functionDate"]   ?> </td>
                        <td style="color:white; background:rgba(0, 0, 0, 0.7); widht:50"> <?php echo $ticketObject["functionTime"]   ?> </td>
                        <td style="color:white; background:rgba(0, 0, 0, 0.7); widht:50"> <?php echo $ticketObject["ticketsPurchased"] ?> </td>
                        <td style="color:white; background:rgba(0, 0, 0, 0.7); widht:50"> <?php echo $ticketObject["movieName"]?> </td>
                        <td style="color:white; background:rgba(0, 0, 0, 0.7); widht:50"> <img src="<?php echo $ticketObject["qr"]?>" > </td>
                    </tr>
            <?php } 
                }?>
                <tbody>
            </table>

            <?php
            if (isset($addMessage) && $addMessage != "") {
                echo "<div class='alert alert-primary' role='alert'> $message </div>";
            }
            ?>
        </div>
    </section>
</main>