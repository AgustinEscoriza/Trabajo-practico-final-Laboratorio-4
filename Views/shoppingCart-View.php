<?php
   //use Controllers\UserController as UserController;
   //$userController = new UserController();
   //$userController->userCheck();
  
    use DAO\MovieDAOmysql as MovieDAO;
    require_once("nav.php");
    $movieDAO = new MovieDAO();
?>
<main class = "py-5">
    <section class = "mb-5" >
        <div class = "container">
            <form method="post" id="columnarForm">
            <table class = "table" style="color:white; text-align:center; background:rgba(0, 0, 0, 0.7)">
                <thead>
                    <tr>
                        <th style="width: 15%;">Movie</th>
                        <th style="width: 15%;">Cinema</th>
                        <th style="width: 15%;">Auditorium</th>
                        <th style="width: 15%;">Time</th>
                        <th style="width: 15%;">Date</th>
                        <th style="width: 10%;">Total</th>
                        <th style="width: 10%;">Remove</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $count = 0;
                    if(!empty($newTicketList)){
                        foreach ($newTicketList as $ticketObject) { ?>
                        <tr>
                        <td> <?php echo $ticketObject["movieName"] ?> </td>
                        <td> <?php echo $ticketObject["cinemaName"] ?> </td>
                        <td> <?php echo $ticketObject["auditoriumName"]?> </td>
                        <td> <?php echo $ticketObject["functionTime"]?> </td>
                        <td> <?php echo $ticketObject["functionDate"] ?> </td>
                        <td> <?php echo $ticketObject["price"]  ?> </td>
                        <td>
                            <button type="submit" name="index" class="btn btn-danger" value="<?php echo $count ?>" onclick="submitForm('<?php echo FRONT_ROOT ?>Ticket/RemoveFromCart')"> Remove </button>
                        </tr>
                    <?php $count++;
                            } ?>
                <tbody>
            </table>
            </form>
            <li class="list-group">
                    <?php if(!empty($ticketList)){ ?>
                    <a class="btn btn-warning"  href="<?php echo FRONT_ROOT; ?>Ticket/purchaseView">
                        Confirm Purchase</a>
                    <?php } }?>
                </li>

            <?php
            if (isset($addMessage) && $addMessage != "") {
                echo "<div class='alert alert-primary' role='alert'> $addMessage </div>";
            }
            ?>
        </div>
    </section>
</main>
<script>
function submitForm(action)
    {
         var form = document.getElementById('columnarForm');
        form.action = action;
        form.submit();
    }
</script>