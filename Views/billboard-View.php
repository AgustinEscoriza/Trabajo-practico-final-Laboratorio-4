<?php
      // use Controllers\UserController as UserController;
       //$userController = new UserController();
       //$userController->userCheck();
      

    require_once('nav.php');
    //require_once('Config\Autoload.php');
  
?>
<link rel="stylesheet" href="../Views/css/movies-list.css">
<main class="py-5">
     <section id="listado" class="mb-5">
          <div class="container">
          <h2 style="text-align:center; color:white; background:rgba(0, 0, 0, 0.7); widht:50; border-style: solid;"><?php echo 'Cinema '.$cinema->getName() ?></h2>
               <form style="text-align:center" method="post" id="columnarForm">
               <?php  if (isset($_SESSION['userLogin'])){
                                                  $userLogin=$_SESSION['userLogin'];
                                                  if($userLogin->getUserRole()==1){
                                                   ?>                                  
               <button type="submit" name="cinemaId" class="btn btn-success" value="<?php echo $cinemaId ?>" onclick="submitForm('<?php echo FRONT_ROOT ?>Function/showAddView')"> Add Function</button>
               <?php } }?>
               <input type="hidden" name="auditoriumId" value="0" class="form-control">
               </form>
              <?php
                if(isset($addMessage) && $addMessage!=1){ 
              ?> 
                <div class="movieSelect" style="display:block; align-items: center; text-align: center; max-width:500">
                  <h5 style="color:white; background:rgba(0, 0, 0, 0.7); widht:50;"> <?php echo $addMessage; ?> </h5>
                </div>
              <?php
                }
              ?>
          
              
               
                 
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