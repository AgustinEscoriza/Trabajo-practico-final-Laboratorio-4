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