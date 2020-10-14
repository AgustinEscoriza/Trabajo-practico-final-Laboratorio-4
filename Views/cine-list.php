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
               <h2 class="mb-4">Listado de cines</h2>

               <table class="table bg-light-alpha">
               <form action="<?php echo FRONT_ROOT ?>Cine/Remove" method="post">
                    <thead>
                         <th>Nombre</th>
                         <th>Direccion</th>
                         <th>Capacidad</th>
                         <th>Valor de Entrada</th>
                    </thead>
                    <tbody>
                         <?php
                              
                              foreach($cineList as $cine)
                              {
                                   ?>
                                        <tr>
                                             <td><?php echo $cine->getName() ?></td>
                                             <td><?php echo $cine->getAdress() ?></td>
                                             <td><?php echo $cine->getCapacity() ?></td>
                                             <td><?php echo $cine->getTicketValue() ?></td>
                                             <td><button type="submit" name="remove" class="btn btn-danger" value="<?php echo $cine->getId(); ?>"> Remove </button></td> 
                                             <td><button type="submit" name="modify" class="btn btn-danger" value="<?php echo $cine->getId(); ?>"> Modify </button></td> 
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