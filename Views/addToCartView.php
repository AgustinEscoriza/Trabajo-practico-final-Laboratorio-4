<?php
   //use Controllers\UserController as UserController;
   //$userController = new UserController();
   //$userController->userCheck();
   
    require_once("nav.php");
?>

<div>

    <h3 class="mb-5">Ticket To<?php echo $movie->getName(); ?></h3>
    <p class = "mb-5"> Total :$<?php if (isset($ticket)) {
                                            echo $ticket->getPrice();
                                        } ?> </p>
    <p class = "mb-5"> Total Seats: <?php echo $ticket->getQuantity(); ?></p>
    <div class="col text-center">
                <a href="<?php echo FRONT_ROOT ?>Ticket/addToCart/1" class="btn btn-primary">Add to car</a>
            </div>
            <br>
            <div class="col text-center">
                <a href="<?php echo FRONT_ROOT ?>Ticket/addToCart/" class="btn btn-primary">Cancel</a>
            </div>
</div>