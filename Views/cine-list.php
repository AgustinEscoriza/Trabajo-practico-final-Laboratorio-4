<?php
    require_once('nav.php');
    require_once('Config\Autoload.php');
    use Models\Cine as Cine;
    use DAO\CineDAO as CineDAO;   
    
    $cineDAO = new CineDAO();
    $cineList = $cineDAO->getAll();
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
                         <th>Show Auditoriums</th>
                         <th>Remove </th>
                         <th>Modify  </th>
                    </thead>
                    <tbody>
                         <?php
                              
                              foreach($cineList as $cine)
                              {
                                   ?>
                                        <tr>
                                             <td><?php echo $cine->getName() ?></td>
                                             <td><?php echo $cine->getAdress() ?></td>
                                             <td><button type="submit" name="cinemaId" class="btn btn-dark ml-auto " value="<?php echo $cine->getId(); ?>" onclick="submitForm('<?php echo FRONT_ROOT ?>Auditorium/ShowListView')"> Show Auditoriums </button></td>
                                             <td><button type="submit" name="remove" class="btn btn-danger" value="<?php echo $cine->getId(); ?>" onclick="submitForm('<?php echo FRONT_ROOT ?>Cine/Remove')"> Remove </button></td> 
                                             <td><button type="submit" name="modify" class="btn btn-dark ml-auto " value="<?php echo $cine->getId(); ?>" onclick="submitForm('<?php echo FRONT_ROOT ?>Cine/Modify')"> Modify </button></td> 
                                        </tr>
                                   <?php
                              }
                         ?>
                         </tr>
                    </tbody>
               </table>
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