<nav class="navbar navbar-expand-lg  navbar-dark bg-dark">
     
     <ul class="navbar-nav ml-auto">
     <?php if(isset($_SESSION["userLogin"])) { 
                $userLogin = $_SESSION["userLogin"]; 
                if($userLogin->getUserRole() == 1) { 
                  ?>
          <li class="nav-item">
               <a class="nav-link" href="<?php echo FRONT_ROOT ?>Movie/cargarDatabaseMoviesGenre">Update DB</a>    
          </li>
          <li class="nav-item">
               <a class="nav-link" href="<?php echo FRONT_ROOT ?>Billboard/showFullList">Show Billboard</a>
          </li>  
          <li class="nav-item">
               <a class="nav-link" href="<?php echo FRONT_ROOT ?>Cinema/showListView">Show Cinemas</a>
          </li>
          <li class="nav-item">
               <a class="nav-link" href="<?php echo FRONT_ROOT ?>User/showAdminDataView">Admin Data</a>
          </li>       
          <li class="nav-item">
               <a class="nav-link" href="<?php echo FRONT_ROOT ?>User/logout">Log Out</a>
          </li>
          <?php } else  {?>
                 <li class="nav-item">
                      <a class="nav-link" href="<?php echo FRONT_ROOT ?>Billboard/showFullList">Show Billboard</a>
                 </li>  
                 <li class="nav-item">
                      <a class="nav-link" href="<?php echo FRONT_ROOT ?>Cinema/showListView">Show Cinemas</a>
                 </li>
                 <li class="nav-item">
                      <a class="nav-link" href="<?php echo FRONT_ROOT ?>User/showUserProfile">My Account</a>
                 </li>     
                 <li class="nav-item">
                      <a class="nav-link" href="<?php echo FRONT_ROOT ?>User/logout">Log Out</a>
                 </li>
          <?php  } }?> 
          
         <?php if(!isset($_SESSION["userLogin"])) {?>
                      <li class="nav-item">
                      <a class="nav-link" href="<?php echo FRONT_ROOT ?>User/showLoginView">Log In</a>
                      </li> 
                      <li class="nav-item">
                      <a class="nav-link" href="<?php echo FRONT_ROOT ?>Billboard/showFullList">Show Billboard</a>
                      </li>  
                      <li class="nav-item">
                      <a class="nav-link" href="<?php echo FRONT_ROOT ?>Cinema/showListView">Show Cinemas</a>
                      </li> 
          <?php  } ?>    

     </ul>
</nav>
