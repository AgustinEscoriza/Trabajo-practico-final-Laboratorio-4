<?php
   use Controllers\UserController as UserController;
   $userController = new UserController();
   $userController->userCheck();
   require_once('nav-user.php');
    require_once('nav.php');
    require_once('Config\Autoload.php');
    use Models\Cinema as Cinema;
?>
<main class="py-5">
     <section id="listado" class="mb-5">
          <div class="container">
               <h2 class="mb-4">Cinema List</h2>
               <form method="post" id="columnarForm">
               <table class="table bg-light-alpha">
              
                    <thead>
                         <th>Name</th>
                         <th>Adress</th>
                         <th style="text-align:center;">Actions </th>
                    </thead>
                    <tbody>
                         <?php     
                              foreach($cinemaList as $cinema)
                              {
                                   ?>
                                        <tr>
                                             <td><?php echo $cinema->getName() ?></td>
                                             <td><?php echo $cinema->getAdress() ?></td>
                                             <td style="text-align: center;">
                                             <button type="submit" name="billboard" class="btn btn-info" value="<?php echo $cinema->getId(); ?>" onclick="submitForm('<?php echo FRONT_ROOT ?>Billboard/ShowBillboard')"> BillBoard </button>                                             
                                             <button type="submit" name="cinemaId" class="btn btn-dark ml-auto " value="<?php echo $cinema->getId(); ?>" onclick="submitForm('<?php echo FRONT_ROOT ?>Auditorium/ShowListView')"> Show Auditoriums </button>
                                             <button type="submit" name="remove" class="btn btn-danger" value="<?php echo $cinema->getId(); ?>" onclick="submitForm('<?php echo FRONT_ROOT ?>Cinema/Remove')"> Remove </button> 
                                             <button type="submit" name="modify" class="btn btn-dark ml-auto " value="<?php echo $cinema->getId(); ?>" onclick="submitForm('<?php echo FRONT_ROOT ?>Cinema/Modify')"> Modify </button>
                                             </td>
                                        </tr>
                                   <?php
                              }
                         ?>
                         </tr>
                    </tbody>
               </table>
               <br>
               <button type="submit" name=" " class="btn btn-dark ml-auto d-block" value=" " onclick="submitForm('<?php echo FRONT_ROOT ?>Cinema/ShowAddView')"> Add Cinema</button>
          </div>
     </section>
</main>

<script>
function submitForm(action)
    {
         var form = document.getElementById('columnarForm');
        form.action = action;
        form.submit();
    }
</script>