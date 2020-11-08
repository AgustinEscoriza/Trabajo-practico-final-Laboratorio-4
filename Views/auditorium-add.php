<?php
  if(isset($_SESSION["userLogin"])) { 
     $userLogin = $_SESSION["userLogin"]; 
     if($userLogin->getUserRole() != 1){
          echo  "<script> alert ('debe loguearse'); </script>";
          require_once(VIEWS_PATH."user-Login.php");
     }
 
  }
    require_once('nav-auditorium.php');
?>

<main class="py-5">
     <section id="listado" class="mb-5">
          <div class="container">
               <h2 class="mb-4">Add Auditorium</h2>
               <form action="<?php echo FRONT_ROOT ?>Auditorium/Add" method="post" class="add-form bg-light-alpha p-5">
                    <div class="row">                       
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="">Name</label>
                                   <input type="text" name="name" value="" class="form-control" required>
                              </div>
                         </div>

                         <input type="hidden" name="cinemaId" value="<?php echo $cinemaId?>" class="form-control">
                    </div>
                    <div class ="row">
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="">Capacity</label>
                                   <input type="number" name="capacity" value="" class="form-control" required>
                              </div>
                         </div>
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="">Ticket Value</label>
                                   <input type="number" name="ticketValue" value="" class="form-control" required>
                              </div>
                         </div>
                         
                    </div>

                    <div class ="row">
                         <?php
                           if(isset($addMessage) && $addMessage!=1){
                           echo $addMessage;
                           }
                         ?>   
                    </div>
                    <button type="submit" name="button" class="btn btn-dark ml-auto d-block">Add</button>
               </form>
          </div>
     </section>

    