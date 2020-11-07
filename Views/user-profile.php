<?php

    use Controllers\UserController as UserController;
    $userController = new UserController();
    $userController->userCheck();
    require_once('nav-user.php');
?>
<main class="d-flex align-items-center justify-content-center height-100">
          <div class="content">
          
          <div class="mb-1 text-muted small">Usuario: <?php echo $userProfile->getUserName();?></div>
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