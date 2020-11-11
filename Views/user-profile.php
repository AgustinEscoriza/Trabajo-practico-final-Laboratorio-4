<?php

    if(isset($_SESSION["userLogin"])) { 
      //$userProfile = $_SESSION["userLogin"];
      }else{ 
        echo  "<script> alert ('debe loguearse'); </script>";
        require_once(VIEWS_PATH."user-Login.php");
       } 
    require_once('nav.php');
?>
<main class="d-flex align-items-center justify-content-center height-90" style="color:white; text-align:center;">
          <div class="content">
          
          <div class="mb-1 text-muted "><h5>User: <?php echo $userProfile->getUserName();?></h4></div>
          <h5 class= "mb-1 text-muted "><br>Order Tickets by:</h4>

          <form action="<?php echo FRONT_ROOT ?>User/orderTicketByMovie" method="post" class="btn" style="background-color:RED;color:white;background:rgba(0, 0, 0, 0.7); width:40%">

                  <div class = "form group" style="display:flex;">

                    <label >Movie Name</label>
                    <input type="text" style="margin-left:20px; width:250px" name="movieName" class="form-control" required>

                 </div>
             <button style="margin-top:20px;" type="submit" name="button" class="btn">Search</button>

         </form>

         <form action="<?php echo FRONT_ROOT ?>User/orderTicketByDate" method="post" class="btn" style="background-color:RED;color:white;background:rgba(0, 0, 0, 0.7); width:40%">

                  <div class = "form group" style="display:flex;">

                    <label >Movie Date</label>
                    <input style="margin-left:20px; width:250px" name="movieDate"  class="form-control" type="date" id="date"  required>

                 </div>
            <button style="margin-top:20px;" type="submit" name="button" class="btn">Search</button>

        </form>
    
             <table class = "table"style="background:rgba(0, 0, 0, 0.7); margin-top:30px;" >
                <thead>
                  <tr>
                    <th style="width: 150px;">Date</th>
                    <th style="width: 100px;">Time</th>
                    <th style="width: 400px;">Movie</th>
                    <th style="width: 200px;">Cinema</th>
                    <th style="width: 200px;">Auditorium</th>               
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