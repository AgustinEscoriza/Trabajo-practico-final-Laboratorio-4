<?php
if(isset($_SESSION["userLogin"])) { 
     $userLogin = $_SESSION["userLogin"]; 
     if($userLogin->getUserRole() != 1){
          echo  "<script> alert ('debe loguearse'); </script>";
          require_once(VIEWS_PATH."user-Login.php");
     }
 
  }
   require_once('nav.php');
   ?>
<main class="py-5">
     <section id="listado" class="mb-5">
          <div class="container">
               <h2 class="mb-4">Modify Auditorium</h2>
               <table class="table bg-light-alpha">
                    <thead>
                         <th>Name</th>
                         <th>Capacity</th>
                         <th>Ticket Value</th>
                    </thead>
                    <tbody>
                            <tr>
                                <td><?php echo $auditorium->getName() ?></td>
                                <td><?php echo $auditorium->getCapacity() ?></td>
                                <td><?php echo $auditorium->getTicketValue() ?></td>
                            </tr>
                         </tr>
                    </tbody>
               </table>
               <form action="<?php echo FRONT_ROOT ?>Auditorium/Modify" method="post" class="bg-light-alpha p-5">
                    <div class="row">                       
                         <div class="col-lg-4">
                         <input type="hidden" name="idAuditorium" value="<?php echo $auditorium->getId();?>" class="form-control">
                              <div class="form-group">
                                   <label for="">Name</label>
                                   <input type="text" name="name" value="<?php echo $auditorium->getName() ?>" class="form-control">
                              </div>
                         </div>
                         
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="">Capacity</label>
                                   <input type="text" name="capacity" value="<?php echo $auditorium->getCapacity() ?>" class="form-control">
                              </div>
                         </div>
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="">Ticket Value</label>
                                   <input type="text" name="ticketValue" value="<?php echo $auditorium->getTicketValue() ?>" class="form-control">
                              </div>
                         </div>
                        
                    </div>
                    <button type="submit" name="button" class="btn btn-dark ml-auto d-block">Modify</button>
               </form>
          </div>
     </section>
</main>