<?php
   //use Controllers\UserController as UserController;
   //$userController = new UserController();
   //$userController->userCheck();
  

    require_once("nav.php");

?>
<main class = "py-5">
    <section class = "mb-5">
        <div class = "container" style="color:white; text-align:center;">
            <table class = "table" style="background:rgba(0, 0, 0, 0.7); widht:50;">
                <thead>
                    <tr>
                        <th style = "width: 15%;"> </th>
                        <th style = "width: 15%;">Movie</th>
                        <th style = "width: 10%;">Cinema</th>
                        <th style = "width: 10%;">Auditorium</th>
                        <th style = "width: 10%;">Date</th>
                        <th style = "width: 10%;">Time</th>
                    </tr>
                </thead>
                <tbody >
                        <td> <img src=<?php echo IMAGE_ROOT. $movie->getPosterPath();?>> </img> </td>
                        <td> <?php echo $movie->getTitle(); ?> </td>
                        <td> <?php echo $cinema->getName();?> </td>
                        <td> <?php echo $auditorium->getName()?> </td>
                        <td> <?php echo $function->getDate();  ?> </td>
                        <td> <?php echo $function->getTime(); ?> </td>
                <tbody>
            </table>
            <h1 class = "mb-5" style="background:rgba(0, 0, 0, 0.7); widht:50;">Buy Ticket</h1>

            <form action="<?php echo FRONT_ROOT ?>Ticket/setAndValidatePurchase" method="post" class="add-form bg-light-alpha p-5">

                <input type="hidden" name="functionId" value="<?php echo $function->getId()?>"required>
                <input type="hidden" name="ticketValue" value="<?php echo $auditorium->getTicketValue()?>"required>
                <input type="hidden" name="capacity" value="<?php echo $auditorium->getCapacity()?>"required>

                <div class = "form group">

                    <label for="" >Quantity</label>
                    <input type="number" name="quantity" size="30" min="1" class="form-control" required>

                </div>
                <button type="submit" name="button" class="btn btn-success" style="margin-top:15px;">Generate Ticket</button>

            </form>

            <?php
            if (isset($addMessage) && $addMessage != "") {
                echo "<div class='alert alert-primary' role='alert'> $addMessage </div>";
            }
            ?>
        </div>
    </section>
</main>