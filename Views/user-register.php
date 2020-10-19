<?php
    require_once('nav-user.php');
?>
<main class="d-flex align-items-center justify-content-center height-100">
          <div class="content">
               <form action="<?php echo FRONT_ROOT ?>User/Add" method="post" class="login-form bg-dark-alpha p-5 text-white">
                    <div class="form-group">
                         <label for="">Nombre de Usuario</label>
                         <input type="text" name="userName" class="form-control form-control-lg" placeholder="Ingresar usuario" required>
                    </div>
                    <div class="form-group">
                         <label for="">E-mail</label>
                         <input type="email" name="userEmail" class="form-control form-control-lg" placeholder="Ingresar E-mail" required>
                    </div>
                    <div class="form-group">
                         <label for="">Contraseña</label>
                         <input type="password" name="password" class="form-control form-control-lg" placeholder="Ingresar constraseña" required>
                    </div>
                    <div class="form-group">
                      <?php
                          if(isset($message)){
                          echo $message ;
                          }
                       ?> 
                    </div>
                    <button class="btn btn-dark btn-block btn-lg" type="submit">Crear cuenta</button>
               </form>
               <br>
          </div>                
     </main>