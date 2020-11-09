<?php
   //use Controllers\UserController as UserController;
   //$userController = new UserController();
   //$userController->userCheck();
  
    use DAO\MovieDAOmysql as MovieDAO;
    require_once("nav.php");
    $movieDAO = new MovieDAO();
?>
<main class = "py-5">
    <section class = "mb-5">
        <div class = "container">
            <table class = "table">
                <thead>
                    <tr>
                        <th style="width: 15%;">Movie</th>
                        <th style="width: 15%;">Time</th>
                        <th style="width: 15%;">Date</th>
                        <th style="width: 10%;">Total</th>
                        <th style="width: 10%;">Remove</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ticketList as $ticket) { ?>
                        <tr>
                        <?php  $movie = $movieDAO->GetMovieByFunctionId($ticket->getFunction()->getId()); // no quiero llamar a un dao adentro de la vista pero no tengo otra opcion en este caso, ya que function no contiene una pelicula?>  
                        <td> <?php echo $movie->getTitle(); ?> </td>
                        <td> <?php echo $ticket->getFunction()->getTime();?> </td>
                        <td> <?php echo $ticket->getFunction()->getDate()?> </td>
                        <td> <?php echo $ticket->getPrice();  ?> </td>
                        <td><button type="submit" name="ticketId"
                                    value="<?php echo $ticket->getId(); ?>" class="btn btn-danger">
                                    Remove </button></td>
                        </tr>
                    <?php } ?>
                <tbody>
            </table>
            <li class="list-group">
                    <?php if(!empty($ticketList)){ ?>
                    <a class="btn btn-warning"  href="<?php echo FRONT_ROOT; ?>Ticket/purchaseView">
                        Confirm Purchase</a>
                    <?php } ?>
                </li>

            <?php
            if (isset($addMessage) && $addMessage != "") {
                echo "<div class='alert alert-primary' role='alert'> $addMessage </div>";
            }
            ?>
        </div>
    </section>
</main>