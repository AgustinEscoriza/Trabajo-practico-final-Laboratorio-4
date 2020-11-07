<?php

    require_once("nav.php");

?>
<main class = "py-5">
    <section class = "mb-5">
        <div class = "container">
            <table class = "table">
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
                <tbody>
                        <td> <?php echo $movie->getPosterPath(); ?> </td>
                        <td> <?php echo $movie->getName(); ?> </td>
                        <td> <?php echo $cinema->getName();?> </td>
                        <td> <?php echo $auditorium->getName()?> </td>
                        <td> <?php echo $function->getDate();  ?> </td>
                        <td> <?php echo $function->getTime(); ?> </td>
                <tbody>
            </table>
            <h1 class = "mb-5">Buy Ticket</h1>

            <form action="<?php echo FRONT_ROOT ?>Ticket/setAndValidatePurchase" method="post" class="add-form bg-light-alpha p-5">

                <input type="hidden" name="function" value="<?php echo $function?>"required>

                <div class = "form group">

                    <label for="" >Quantity</label>
                    <input type="number" name="quantity" size="30" min="1" class="form-control" required>

                </div>
                <button type="submit" name="button" class="btn btn-success">Generate Ticket</button>

            </form>

            <?php
            if (isset($addMessage) && $addMessage != "") {
                echo "<div class='alert alert-primary' role='alert'> $message </div>";
            }
            ?>
        </div>
    </section>
</main>