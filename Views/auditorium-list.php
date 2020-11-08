<?php
  if(isset($_SESSION["userLogin"])) { 
     $userLogin = $_SESSION["userLogin"]; 
     if($userLogin->getUserRole() != 1){
          echo  "<script> alert ('debe loguearse'); </script>";
          require_once(VIEWS_PATH."user-Login.php");
     }
 
  }
   
    require_once('nav-auditorium.php');
    require_once('Config\Autoload.php');

    use Models\Auditorium as Auditorium;
    use DAO\AuditoriumDAO as AuditoriumDAO;
?>
<main class="py-5">
     <section id="listado" class="mb-5">
          <div class="container">
               <h2 class="mb-4">Auditorium List</h2>
               <form method="post" id="columnarForm">
               <table class="table bg-light-alpha">
              
                    <thead>
                         <th>Name</th>
                         <th>Capacity</th>
                         <th>Ticket Value </th>
                         <th>Actions  </th>
                    </thead>
                    <tbody>
                         <?php
                              if(!empty($auditoriumList)){
                                   foreach($auditoriumList as $auditorium)
                                   {
                                   ?>
                                        <tr>
                                             <td><?php echo $auditorium->getName() ?></td>
                                             <td><?php echo $auditorium->getCapacity() ?></td>
                                             <td><?php echo $auditorium->getTicketValue() ?></td>
                                             <td style="display:flex">
                                                  <form method="post" id="columnarForm">
                                                       <button type="submit" name="remove" class="btn btn-danger" value="<?php echo $auditorium->getId(); ?>" onclick="submitForm('<?php echo FRONT_ROOT ?>Auditorium/Remove')"> Remove </button> 
                                                       
                                                       <button type="submit" name="modify" class="btn btn-dark" value="<?php echo $auditorium->getId(); ?>" onclick="submitForm('<?php echo FRONT_ROOT ?>Auditorium/Modify')"> Modify </button>                    
                                                       
                                                       <button type="submit" name="Add" class="btn btn-success" value="<?php echo $cinemaId ?>" onclick="submitForm('<?php echo FRONT_ROOT ?>Function/showAddView')"> Add Function</button>
                                                       <input type="hidden" name="idAuditorium" value="<?php echo $auditorium->getId(); ?>" class="form-control">
                                                  </form>
                                             </td> 
                                        </tr>
                                   <?php
                                   }
                              }
                         ?>
                         </tr>
                    </tbody>
               </table>
               <br>
               <br>
               <br>
               <button type="submit" name="cinemaId" class="btn btn-dark ml-auto d-block" value="<?php echo $cinemaId ?>" onclick="submitForm('<?php echo FRONT_ROOT ?>auditorium/showAddView')"> Add Auditorium</button>
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