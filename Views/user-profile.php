<?php

    if(isset($_SESSION["userLogin"])) { 
      //$userProfile = $_SESSION["userLogin"];
      echo "esta loguedo" ;
      }else{ 
        echo  "<script> alert ('debe loguearse'); </script>";
        require_once(VIEWS_PATH."user-Login.php");
       } 
    require_once('nav.php');
?>
<main class="d-flex align-items-center justify-content-center height-100">
          <div class="content">
          
          <div class="mb-1 text-muted small">User: <?php echo $userProfile->getUserName();?></div>
          <h6 class= "mb-1 text-muted small"><br>Order Tickets by:</h6>
          <a href="<?php echo FRONT_ROOT;?>Ticket/orderByCinema"  class="btn" style="background-color:RED;color:white;" >Cinema</a>
          <a href="<?php echo FRONT_ROOT;?>Ticket/orderByDate"  class="btn" style="background-color:RED;color:white;" >Date</a>
    
             <table class = "table">
                <thead>
                  <tr>
                    <th style="width: 100px;">Dia</th>
                    <th style="width: 100px;">Hora</th>
                    <th style="width: 400px;">Pelicula</th>
                    <th style="width: 200px;">Cine</th>
                    <th style="width: 200px;">Sala</th>               
                  </tr>
                </thead>
                <tbody>
                <?php if(!empty($newTicketList)) { foreach($newTicketList as $ticket) { ?>
                  <tr>
                    <td><?php echo $ticket["functionDate"]; ?></td>
                    <td><?php echo $ticket["functionTime"]; ?></td>
                    <td><?php echo $ticket["movieName"]; ?></td> <!-- esto deberia despues cambiarse por un getmovie()->getName();-->
                    <td><?php echo $ticket["cinemaName"]; ?></td>
                    <td><?php echo $ticket["auditoriumName"]; ?></td>     
                    
                    <!--<td>
                      <form action="" method="get">
                        <button type="submit" class="btn" name="idTicket" style="background-color:GREEN;color:white;" value="<?php echo $ticket->getId();?>">Ver</button>
                      </form>
                    </td>-->
                  </tr>
                <?php } } else {?><tr><td colspan=7;><?php echo "No dispone de entradas adquiridas al momento";}?></td></tr>
                </tbody>
            </table>
          </div>


     </main>