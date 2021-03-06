<?php
  if(isset($_SESSION["userLogin"])) { 
     $userLogin = $_SESSION["userLogin"]; 
     if($userLogin->getUserRole() != 1){
          echo  "<script> alert ('debe loguearse'); </script>";
          require_once(VIEWS_PATH."user-Login.php");
     }
 
  }
   require_once('nav.php');
     require_once('Config\Autoload.php');
     use Models\Cinema as Cinema;
?>
<main class="py-5">
     <section id="listado" class="mb-5">
          <div class="container" style="color:white; text-align:center;">
               <h2 class="mb-4" style="text-align:center; color:white; background:rgba(0, 0, 0, 0.7); widht:50; border-style: solid;">Modify Cinema</h2>
               <table class="table bg-light-alpha">
                    <thead>
                         <th>Name</th>
                         <th>Adress</th>
                    </thead>
                    <tbody>
                            <tr>
                                <td><?php echo $cinema->getName() ?></td>
                                <td><?php echo $cinema->getAdress() ?></td>
                            </tr>
                         </tr>
                    </tbody>
               </table>
               <form action="<?php echo FRONT_ROOT ?>Cinema/Modify" method="post" class="bg-light-alpha p-5">
                    <div class="row">                       
                         <div class="col-lg-4">

                              <input type="hidden" name="cinemaId" value="<?php echo $cinemaId?>" class="form-control">

                              <div class="form-group">
                                   <label for="">New Name</label>
                                   <input type="text" name="name" value="<?php echo $cinema->getName() ?>" class="form-control">
                              </div>
                         </div>
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="">New Adress</label>
                                   <input type="text" name="adress" value="<?php echo $cinema->getAdress() ?>" class="form-control">
                              </div>
                         </div>
                        
                    </div>
                    <button type="submit" name="button" class="btn btn-dark ml-auto d-block">Modify</button>
               </form>
          </div>
     </section>
</main>