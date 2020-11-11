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
    use \DateTime as NewDT;
?>
<main class="d-flex" style="color:white; text-align:center;">
          <div id="sidebar-container" class="bg-primary">
          <div class="menu">
          <a href="<?php echo FRONT_ROOT ?>User/getUsersList" class="d-block p-3 text-light">Users </a>
          <a href="<?php echo FRONT_ROOT ?>User/showStatisticsTotalSold" class="d-block p-3 text-light">Statistics: Total Sold </a>
          <a href="<?php echo FRONT_ROOT ?>User/showStatisticsRemaining" class="d-block p-3 text-light">Statistics: Remaining Tickets </a>
          </div>
          </div>
          
     <div style="align-items: center; text-align: center; width:50%">
    <h3 style="color:white; background:rgba(0, 0, 0, 0.7); widht:50;">Cinema:</h3>
   
    <form action="<?php echo FRONT_ROOT ?>Ticket/getTicketByDate" method="post"  id="cinemaForm">
      <select name="cinemaSelector" id="cinemaSelector"  style="margin-top:20px;" >
        <option type="submit"  value="0">Todos</option>
          <?php foreach($cinemaList as $cinema){   ?>  
          <div >   
            <option type="submit"  id="" value=<?php echo $cinema->getId(); ?>  ?>
              <?php echo $cinema->getName(); ?> 
            </option>
            </div>
          <?php } ?>
          
      </select>
      <div style="display:flex; width:100%;">
   <div>
    <h5> Desde </h5>
      <input style="margin-left:15px; " name="dateFrom" type="date" id="dateFrom"  value="<?php echo $dateFrom->format('Y-m-d') ?>"  required >
      </div>
      <div>
    <h5 style="margin-left:10px;"> Hasta </h5>
      <input type="date" id="dateTo" name="dateTo" value="<?php echo $dateTo->format('Y-m-d') ?>" style="margin-left:10px;">
      </div>
      <button class="btn btn-primary "type="submit" style="margin-left:10px; margin-top: 20px; height:40px;">Buscar</button>
      </form>

          <div id="tickets">
          <section id="ticketsSold" class="mb-5">
          <div class="container">
               <h2 class="mb-4">Total Tickets Sold</h2>
               <table class="table bg-light-alpha">
              
                    <thead>
                         <th>Cinema</th>
                         <th>Price</th> 
                    </thead> 
                    <tbody>
                         <?php if(!empty($newTicketList)){   
                              foreach($newTicketList as $ticket)
                              {
                                   ?>
                                        <tr>
                                             <td style="color:white; background:rgba(0, 0, 0, 0.7);"><?php echo $ticket["cinemaName"]; ?></td>
                                             <td style="color:white; background:rgba(0, 0, 0, 0.7);"><?php echo $ticket["price"]; ?></td>
                                             
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
          <br> 


       
		<br>
	</div> 
 </main>