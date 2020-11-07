<?php
   use Controllers\UserController as UserController;
   $userController = new UserController();
   $userController->userCheck();
   require_once('nav-user.php');
   ?>

<main class="py-5">
     <section id="listado" class="mb-5">
          <div class="container">
               <h2 class="mb-4">Modify Cinema</h2>
               <table class="table bg-light-alpha">
                    <thead>
                         <th>Name</th>
                         <th>Adress</th>
                    </thead>
                    <tbody>
                            <tr>
                                <td><?php echo $cine->getName() ?></td>
                                <td><?php echo $cine->getAdress() ?></td>
                            </tr>
                         </tr>
                    </tbody>
               </table>
               <form action="<?php echo FRONT_ROOT ?>Cine/Add" method="post" class="bg-light-alpha p-5">
                    <div class="row">                       
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="">Name</label>
                                   <input type="text" name="name" value="" class="form-control">
                              </div>
                         </div>
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="">Adress</label>
                                   <input type="text" name="adress" value="" class="form-control">
                              </div>
                         </div>
                        
                    </div>
                    <button type="submit" name="button" class="btn btn-dark ml-auto d-block">Modify</button>
               </form>
          </div>
     </section>
</main>