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
          <div class="container" style="color:white; text-align:center;">
          <h2 class="mb-4" style="text-align:center; color:white; background:rgba(0, 0, 0, 0.7); widht:50; border-style: solid;">Add Cinema</h2>
               <form action="<?php echo FRONT_ROOT ?>Cinema/Add" method="post" class="add-form bg-light-alpha p-5">
                    <div class="row">                       
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="">Name</label>
                                   <input type="text" name="name" value="" class="form-control" required>
                              </div>
                         </div>
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="">Adress</label>
                                   <input type="text" name="adress" value="" class="form-control" required>
                              </div>
                         </div>
                        
                    </div>

                    <div class ="row">
                         <?php
                           if(isset($addMessage)){
                           echo $addMessage;
                           }

                           if(isset($message) && $message!=1){ ?> 
                              <div class="movieSelect" style="display:block; align-items: center; text-align: center; max-width:500">
                              <h5 style="color:white; background:rgba(0, 0, 0, 0.7); widht:50;"> <?php echo $message; ?> </h5>

                              <?php }
                         ?>   
                    </div>
                    <button type="submit" name="button" class="btn btn-dark ml-auto d-block">Add</button>
               </form>
          </div>
     </section>

    
</main>