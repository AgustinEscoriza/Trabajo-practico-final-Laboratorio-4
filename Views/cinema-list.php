<?php
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
                         <th>Show Auditoriums</th>
                         <th> </th>
                         <th>  </th>
                    </thead>
                    <tbody>
                         <?php
                              
                              foreach($cinemaList as $cinema)
                              {
                                   ?>
                                        <tr>
                                             <td><?php echo $cinema->getName() ?></td>
                                             <td><?php echo $cinema->getAdress() ?></td>
                                             <td><button type="submit" name="cinemaId" class="btn btn-dark ml-auto " value="<?php echo $cinema->getId(); ?>" onclick="submitForm('<?php echo FRONT_ROOT ?>Auditorium/ShowListView')"> Show Auditoriums </button></td>
                                             <td><button type="submit" name="remove" class="btn btn-danger" value="<?php echo $cinema->getId(); ?>" onclick="submitForm('<?php echo FRONT_ROOT ?>Cinema/Remove')"> Remove </button></td> 
                                             <td><button type="submit" name="modify" class="btn btn-dark ml-auto " value="<?php echo $cinema->getId(); ?>" onclick="submitForm('<?php echo FRONT_ROOT ?>Cinema/ShowModifyView')"> Modify </button></td> 
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