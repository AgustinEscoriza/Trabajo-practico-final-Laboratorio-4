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
?>
<main class="d-flex" style="color:white; text-align:center;">
          <div id="sidebar-container" class="bg-primary">
          <div class="menu">
          <a href="<?php echo FRONT_ROOT ?>User/getUsersList" class="d-block p-3 text-light">Users </a>
          <a href="<?php echo FRONT_ROOT ?>User/showStatisticsTotalSold" class="d-block p-3 text-light">Statistics: Total Sold </a>
          <a href="<?php echo FRONT_ROOT ?>User/showStatisticsRemaining" class="d-block p-3 text-light">Statistics: Remaining Tickets </a>
          </div>
          </div>

          <div id="content">
              <section id="listado" class="mb-5">
              <div class="container">
               <h2 class="mb-4">Users List</h2>
               <form method="post" id="columnarForm">
               <table class="table bg-light-alpha">
              
                    <thead>
                         <th>ID</th>
                         <th>Name</th>
                         <th>Email</th>
                         <th>Role</th>
                         <th>State</th>     
                    </thead>
                    <tbody>
                         <?php     
                              foreach($usersList as $user)
                              {
                                   ?>
                                        <tr>
                                             <td><?php echo $user->getIdUser() ?></td>
                                             <td><?php echo $user->getUserName() ?></td>
                                             <td><?php echo $user->getUserEmail() ?></td>
                                             <td><?php echo $user->getUserRole() ?></td>
                                             <td><?php echo $user->getUserState() ?></td>
                                             <td style="text-align: center;">
                                             <button type="submit" name="remove" class="btn btn-danger" value="<?php echo $user->getIdUser(); ?>" onclick="submitForm('<?php echo FRONT_ROOT ?>User/deleteUser')"> Remove </button> 
                                        </td>
                                        </tr>
                                   <?php
                              }
                         ?>
                         </tr>
                    </tbody>
               </table>
               <br>
               </section> 
          </div>          
 </main>
 <script>
function submitForm(action)
    {
         var form = document.getElementById('columnarForm');
        form.action = action;
        form.submit();
    }
</script>