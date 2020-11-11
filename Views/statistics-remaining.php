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
    use Models\Functions as Functions;
?>
<main class="d-flex" style="color:white; text-align:center;">
          <div id="sidebar-container" class="bg-primary">
          <div class="menu">
          <a href="<?php echo FRONT_ROOT ?>User/getUsersList" class="d-block p-3 text-light">Users </a>
          <a href="<?php echo FRONT_ROOT ?>User/showStatisticsTotalSold" class="d-block p-3 text-light">Statistics: Total Sold </a>
          <a href="<?php echo FRONT_ROOT ?>User/showStatisticsRemaining" class="d-block p-3 text-light">Statistics: Remaining Tickets </a>
          </div>
          </div>

             <div id="functions">
          <section id="functionList"  class="mb-5">
          <div class="container">
          <h2 class="mb-4" style="text-align:center; color:white; background:rgba(0, 0, 0, 0.7); widht:50; border-style: solid;">Functions</h2>
               <form action="<?php echo FRONT_ROOT ?>Function/getFunctionList" method="post" id="columnarForm">
               <table class="table bg-light-alpha">
              
                    <thead>
                         <th>FunctionID</th>
                         <th>FunctionDate</th>
                         <th>FunctionTime</th>
                         <th>Movie</th>
                    </thead>
                    <tbody>
                         <?php if(!empty($functionMovie)){     
                                   foreach($functionMovie as $function)
                                   {
                                   ?>
                                        <tr>
                                             <td style="color:white; background:rgba(0, 0, 0, 0.7);"><?php echo $function["idFunction"]; ?></td>
                                             <td style="color:white; background:rgba(0, 0, 0, 0.7);"><?php echo $function["functionDate"]; ?></td>
                                             <td style="color:white; background:rgba(0, 0, 0, 0.7);"><?php echo $function["functionTime"]; ?></td>
                                             <td style="color:white; background:rgba(0, 0, 0, 0.7);"><?php echo $function["movieName"]; ?></td> 
                                             <td style="text-align: center;">
                                             <button type="submit" name="remaining" class="btn btn-info" value="<?php echo $function["idFunction"]; ?>" onclick="submitForm('<?php echo FRONT_ROOT ?>Ticket/getRemainingTickets')"> See Remaining Tickets </button>     
                                        </td>
                                        </tr>
                                   <?php
                                   }
                              }
                         ?>
                         </tr>
                    </tbody>
               </table>
               <button type="submit" name="function" class="btn ">Consult </button>
          </div>
          </section>
          </div>  

           <div id="tickets">
          <section id="remaining" class="mb-5" >
          <div class="container">
               <h2 class="mb-4">Remaining Tickets</h2>
               <form action="<?php echo FRONT_ROOT ?>Ticket/getRemainingTickets" method="post" id="remaining">
               <table class="table bg-light-alpha">
              
                    <thead>
                         <th>FunctionID</th>
                         <th>Movie</th>
                         <th>Tickets Sold</th>
                         <th>Remaining Tickets</th>
                    </thead> 
                    <tbody>
                         <?php if(!empty($newFunctionList)){   
                              foreach($newFunctionList as $function)
                              {
                                   ?>
                                        <tr>
                                             <td style="color:white; background:rgba(0, 0, 0, 0.7);"><?php echo $function["idFunction"]; ?></td>
                                             <td style="color:white; background:rgba(0, 0, 0, 0.7);"><?php echo $function["movieName"]; ?></td>
                                             <td style="color:white; background:rgba(0, 0, 0, 0.7);"><?php echo $function["ticketsSold"]; ?></td>
                                             <td style="color:white; background:rgba(0, 0, 0, 0.7);"><?php echo $function["remaining"]; ?></td>
                                             
                                        </td>
                                        </tr>
                                   <?php
                              }
                         }
                         ?>
                         </tr>
                    </tbody>          
               </table> 
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