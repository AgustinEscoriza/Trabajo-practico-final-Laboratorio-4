<?php
    require_once('nav.php');
?>
<main class="py-5">
     <section id="listado" class="mb-5">
          <div class="container">
               <h2 class="mb-4">Add Cinema</h2>
               <form action="<?php echo FRONT_ROOT ?>Cine/Add" method="post" class="add-form bg-light-alpha p-5">
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
                         ?>   
                    </div>
                    <button type="submit" name="button" class="btn btn-dark ml-auto d-block">Add</button>
               </form>
          </div>
     </section>

    
</main>