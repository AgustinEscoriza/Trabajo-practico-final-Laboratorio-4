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
<main class="d-flex align-items-center justify-content-center height-100" style="color:white; text-align:center;">
          <div class="content">
          
          <div class="mb-1 text-muted small">User: <?php echo $userProfile->getUserName();?></div>
          <h6 class= "mb-1 text-muted small"><br>Order Tickets by:</h6>

          <form action="<?php echo FRONT_ROOT ?>User/orderTicketByMovie" method="post" class="btn" style="background-color:RED;color:white;background:rgba(0, 0, 0, 0.7);">

                  <div class = "form group" style="display:flex;">

                    <label >Movie Name</label>
                    <input type="text" name="movieName" class="form-control" required>

                 </div>
             <button type="submit" name="button" class="btn">Search</button>

         </form>

         <form action="<?php echo FRONT_ROOT ?>User/orderTicketByDate" method="post" class="btn" style="background-color:RED;color:white;background:rgba(0, 0, 0, 0.7);">

                  <div class = "form group" style="display:flex;">

                    <label >Movie Date</label>
                    <input style="width:175px" name="movieDate"  class="form-control" type="date" id="date"  required>

                 </div>
            <button type="submit" name="button" class="btn">Search</button>

        </form>
    
             <table class = "table" >
                <thead>
                  <tr>
                    <th style="width: 100px; ">Dia</th>
                    <th style="width: 100px;">Hora</th>
                    <th style="width: 400px;">Pelicula</th>
                    <th style="width: 200px;">Cine</th>
                    <th style="width: 200px;">Sala</th>               
                  </tr>
                </thead>
                <tbody>
                <?php if(!empty($newTicketList)) 
                   { foreach($newTicketList as $ticket) { ?>
                   <tr>
                    <td style="color:white; background:rgba(0, 0, 0, 0.7);"><?php echo $ticket["functionDate"]; ?></td>
                    <td style="color:white; background:rgba(0, 0, 0, 0.7);"><?php echo $ticket["functionTime"]; ?></td>
                    <td style="color:white; background:rgba(0, 0, 0, 0.7);"><?php echo $ticket["movieName"]; ?></td> 
                    <td style="color:white; background:rgba(0, 0, 0, 0.7);"><?php echo $ticket["cinemaName"]; ?></td>
                    <td style="color:white; background:rgba(0, 0, 0, 0.7);"><?php echo $ticket["auditoriumName"]; ?></td>     
                   </tr>
                <?php } } else {?><tr><td colspan=7;><?php echo "No dispone de entradas adquiridas al momento";}?></td></tr>
                </tbody>
            </table>
          </div>


     </main>