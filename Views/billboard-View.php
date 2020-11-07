<?php
       use Controllers\UserController as UserController;
       $userController = new UserController();
       $userController->userCheck();
       require_once('nav-user.php');

    require_once('nav-billboard.php');
    require_once('Config\Autoload.php');
  
?>
<link rel="stylesheet" href="../Views/css/movies-list.css">
<main class="py-5">
     <section id="listado" class="mb-5">
          <div class="container">
               <h2><?php echo ' | Cinema '.$cinemaId ?></h2>
               <form method="post" id="columnarForm">
               <button type="submit" name="cinemaId" class="btn btn-success" value="<?php echo $cinemaId ?>" onclick="submitForm('<?php echo FRONT_ROOT ?>Function/showAddView')"> Add Function</button>
               <input type="hidden" name="auditoriumId" value="0" class="form-control">
               </form>

              
               
                 
               <?php foreach($moviesList as $res){ ?>  

                       <div class="movieDiv" >
                        
                              <div width="30%">
                                <img src=<?php echo IMAGE_ROOT. $res->getPosterPath();?>> </img>
                              </div>
                              <div class="textDiv">
                                <h4 ><?php echo $res->getTitle();'<br>' ;?></h4>
                                <p><?php echo $res->getOverview();'<br>' ;?></p>
                                <h5>Genres:</h5>
                                  <p>
                                  <?php 
                                    $genreList = $res->getGenre();
                                    foreach ($genreList as $genre) {
                                      echo $genre->getName() . " ";
                                  }?>
                                  </p>
                                  <form method="post" id="columnarFormMovie" action="<?php echo FRONT_ROOT ?>Function/ShowFunctions"> 
                            <input type="hidden" name="cinemaId" value="<?php echo $cinemaId ?>" class="form-control">
                            <input type="hidden" name="auditoriumId" value="0" class="form-control">
                            <input type="hidden" id="idMovie" name="idMovie" value="<?php echo $res->getId(); ?>" class="form-control">
                            <div style="justify-content: flex-end;">
                             <button type="submit" name="button" class="btn btn-success">Functions</button>
                            </div>
                            </form> 
                              </div>
                              
                            
                      </div>
                    
                  
                  <div style ="maheight:250"></div>
                <?php } ?>
                                              
               <br>
               <br>
               <br>
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

    function submitFormMovie(action)
    {
        var form = document.getElementById('columnarFormMovie');
        form.action = action;
        form.submit();
    }
</script>