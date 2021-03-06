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
<link rel="stylesheet" href="../Views/css/movies-list.css">
<main class="py-5">
     <section id="listado" class="mb-5">
          <div class="container">
          <h2 class="mb-4" style="text-align:center; color:white; background:rgba(0, 0, 0, 0.7); widht:50; border-style: solid;">Auditorium List</h2>
             
               <table class="table bg-light-alpha" style="color:white; text-align:center;">
              
                    <thead >
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
                                                  <form method="post" id="columnarForm<?php echo $auditorium->getId(); ?>">
                                                       <button type="submit" name="remove" class="btn btn-danger" value="<?php echo $auditorium->getId(); ?>" onclick="submitForm('<?php echo FRONT_ROOT ?>Auditorium/ChangeAuditoriumStatus',<?php echo $auditorium->getId(); ?>)"> Remove </button> 
                                                       
                                                       <button type="submit" name="modify" class="btn btn-dark" value="<?php echo $auditorium->getId(); ?>" onclick="submitForm('<?php echo FRONT_ROOT ?>Auditorium/showModifyView',<?php echo $auditorium->getId(); ?>)"> Modify </button>                    
                                                       
                                                       <button type="submit" name="Add" class="btn btn-success" value="<?php echo $cinemaId ?>" onclick="submitForm('<?php echo FRONT_ROOT ?>Function/showAddView',<?php echo $auditorium->getId(); ?>)"> Add Function</button>
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
               <div class ="row">
                         <?php
                           if(isset($message) && $message!=1){ ?> 
                              <div class="movieSelect" style="display:block; align-items: center; text-align: center; max-width:500">
                              <h5 style="color:white; background:rgba(0, 0, 0, 0.7); widht:50;"> <?php echo $message; ?> </h5>

                              <?php }
                         ?>   
                    </div>
               <br>
               <div style="text-align:center;">
                    <form method="post" id="columnarForm" action="<?php echo FRONT_ROOT ?>Auditorium/showAddView">
                    <input type="hidden" name="cinemaId" value="<?php echo $cinemaId ?>" class="form-control">
                         <button type="submit" name="cinemaId"  value="<?php echo $cinemaId ?>" class="btn btn-dark"> Add Auditorium</button>
                         
                    </form>
               </div>
          </div>
     </section>
</main>

<script>
function submitForm(action,idAuditorium)
    {
         var form = document.getElementById('columnarForm'+idAuditorium);
        form.action = action;
        form.submit();
    }
</script>