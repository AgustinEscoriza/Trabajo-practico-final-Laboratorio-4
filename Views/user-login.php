<div class="d-flex align-items-center justify-content-center" style="color:#ffd9b3; background-color: rgb(32, 31, 31); border: 2px solid rgba(0, 0, 0, 0.2)">
          <h1>BIENVENIDO A MOVIE PASS</h1>
            </div>
            
<main class="d-flex align-items-center justify-content-center height-100">
          <div class="content">
                <br>
               <form action="<?php echo FRONT_ROOT ?>User/login" method="post" class="login-form bg-dark-alpha p-5 text-white">
                    <div class="form-group">
                         <label for="">Nombre de Usuario</label>
                         <input type="text" name="userName" class="form-control form-control-lg" placeholder="Ingresar usuario" required>
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
                    <button class="btn btn-success btn-block btn-lg" type="submit">Iniciar Sesión</button>
                    <br>
                    <div class="form-group">
							      <a href="<?php echo FRONT_ROOT?>User/fbLogin "class="a-fb">
							    	<div class="fb-button-container">
									   Login with Facebook 
								</div>
							      </a>
				</div>
               </form>
               <br>
               <div class="login-form">
               <a href="<?php echo FRONT_ROOT ?> User/showRegisterView" class="btn btn-info btn-block btn-lg">Registrarse</a>
               </div>
          </div>               
     </main>