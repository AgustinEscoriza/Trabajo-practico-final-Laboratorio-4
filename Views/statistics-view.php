<?php
    if(isset($_SESSION["userLogin"])) { 
      $userAdmin = $_SESSION["userLogin"];
      if($userAdmin->getUserRole()!=1){
        echo  "<script> alert ('debe loguearse'); </script>";
        require_once(VIEWS_PATH."user-Login.php");
      }
    require_once('nav.php');
    }

    use Models\User as User;
    use Models\Cinema as Cinema;
?>
<main class="d-flex">
          <div id="sidebar-container" class="bg-primary">
          <div class="menu">
          <a href="<?php echo FRONT_ROOT ?>User/getUsersList" class="d-block p-3 text-light">Users </a>
          <a href="<?php echo FRONT_ROOT ?>User/showStatisticsView" class="d-block p-3 text-light">Statistics </a>
          </div>
          </div>

          <div id="content">
          <section id="cinemaList" class="mb-5">
          <div class="container">
          <h2 class="mb-4" style="text-align:center; color:white; background:rgba(0, 0, 0, 0.7); widht:50; border-style: solid;">Cinemas</h2>
               <form action="<?php echo FRONT_ROOT ?>Cinema/getCinemaList" method="post" id="columnarForm">
               <table class="table bg-light-alpha">
              
                    <thead>
                         <th>Name</th>
                         <th>Adress</th>
                    </thead>
                    <tbody>
                         <?php  if(!empty($cinemaList)){     
                                   foreach($cinemaList as $cinema)
                                   {
                                   ?>
                                        <tr>
                                             <td><?php echo $cinema->getName() ?></td>
                                             <td><?php echo $cinema->getAdress() ?></td>
                                             <td style="text-align: center;">
                                             <button type="submit" name="consult" class="btn btn-info" value="<?php echo $cinema->getName(); ?>" onclick="submitForm('<?php echo FRONT_ROOT ?>Ticket/getTicketsByCinema')"> See total sold </button>          
                                        </td>
                                        </tr>
                                   <?php
                                   }
                              }
                         ?>
                         </tr>
                    </tbody>
               </table>
               <button type="submit" name="button" class="btn ">Consult</button>
          </div>
          </section>
          </div>  

          <div id="content">
          <section id="listado" class="mb-5">
          <div class="container">
               <h2 class="mb-4">Total Tickets Sold</h2>
               <form action="<?php echo FRONT_ROOT ?>Ticket/getTicketsByCinema" method="post" id="columnarForm">
               <table class="table bg-light-alpha">
              
                    <thead>
                         <th>Cinema</th>
                         <th>Movie</th>
                         <th>Function</th>
                         <th>Quantity</th>
                         <th>Price</th> 
                    </thead> 
                    <tbody>
                         <?php if(!empty($newTicketList)){   
                              foreach($newTicketList as $ticket)
                              {
                                   ?>
                                        <tr>
                                             <td style="color:white; background:rgba(0, 0, 0, 0.7);"><?php echo $ticket["cinemaName"]; ?></td>
                                             <td style="color:white; background:rgba(0, 0, 0, 0.7);"><?php echo $ticket["movieName"]; ?></td>
                                             <td style="color:white; background:rgba(0, 0, 0, 0.7);"><?php echo $ticket["functionId"]->getId(); ?></td>
                                             <td style="color:white; background:rgba(0, 0, 0, 0.7);"><?php echo $ticket["quantity"]; ?></td>
                                             <td style="color:white; background:rgba(0, 0, 0, 0.7);"><?php echo $ticket["price"]; ?></td>
                                             
                                        </td>
                                        </tr>
                                   <?php
                              }
                         }
                         ?>
                         </tr>
                    </tbody>
                    <tfoot>
                    <?php if(!empty($total)) {?>
                          <th>Total: $</th> <td> <?php echo $total ?> </td>
                        <?php } ?>
                    </tfoot>
               </table>
               <button type="submit" name="button" class="btn ">Consult</button>
          </div>
          </section>
          </div>          
 </main>
 <script>
function submitForm(action)
    {
         var form = document.getElementById('columnarForm');
        form.action = action;
        form.submit();
    }
</script>