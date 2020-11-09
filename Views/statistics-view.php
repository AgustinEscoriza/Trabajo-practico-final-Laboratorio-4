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
?>
<main class="d-flex">
          <div id="sidebar-container" class="bg-primary">
          <div class="menu">
          <a href="<?php echo FRONT_ROOT ?>User/getUsersList" class="d-block p-3 text-light">Users </a>
          <a href="<?php echo FRONT_ROOT ?>User/showStatisticsView" class="d-block p-3 text-light">Statistics </a>
          </div>
          </div>

          <div id="content">
          <section id="listado" class="mb-5">
          <div class="container">
               <h2 class="mb-4">Cinema List</h2>
               <form action="<?php echo FRONT_ROOT ?>Cinema/showListView" method="post" id="columnarForm">
               <table class="table bg-light-alpha">
              
                    <thead>
                         <th>Name</th>
                         <th>Adress</th>
                    </thead>
                    <tbody>
                         <?php     
                              foreach($cinemaList as $cinema)
                              {
                                   ?>
                                        <tr>
                                             <td><?php echo $cinema->getName() ?></td>
                                             <td><?php echo $cinema->getAdress() ?></td>
                                        </td>
                                        </tr>
                                   <?php
                              }
                         ?>
                         </tr>
                    </tbody>
               </table>
          </div>
          </section>
          </div>          
 </main>