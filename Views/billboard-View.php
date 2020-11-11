<?php
      // use Controllers\UserController as UserController;
       //$userController = new UserController();
       //$userController->userCheck();
      

    require_once('nav.php');
    //require_once('Config\Autoload.php');
  
?>
<link rel="stylesheet" href="../Views/css/movies-list.css">
<div style="display:flex; width:100%; color:white; background:rgba(0, 0, 0, 0.7); height:120px;">
  <div style="align-items: center; text-align: center; width:50%">
    <h3 style="color:white; background:rgba(0, 0, 0, 0.7); widht:50;">Genero:</h3>
    <form method="post" id="genreForm">
    <input type="hidden" name="cinemaId" value="<?php echo $cinema->getId()?>">
      <select name="genreSelector" id="genreSelector"  onchange="submitForm('<?php echo FRONT_ROOT ?>Billboard/filter')" style="margin-top:20px;" >
        <option type="submit"  value="0">Todos</option>
          <?php foreach($genresList as $genre){   ?>  
          <div >     
            <option type="submit"  id="" value=<?php echo $genre->getId(); ?>  ?>
              <?php echo $genre->getName(); ?> 
            </option>
            </div>
          <?php } ?>
          
      </select>
      
    </form>
  </div>
  <div style="align-items: center; text-align: center; width:50%">
    <h3 style="color:white; background:rgba(0, 0, 0, 0.7); widht:50;">Fecha:</h3>
    <form action="<?php echo FRONT_ROOT ?>Billboard/DateFilter" method="post" id="dateForm" >
   <div style="display:flex; width:100%;">
   <div>
    <h5> Desde </h5>
      <input style="margin-left:15px; " name="dateFrom" type="date" id="dateFrom"  value="<?php echo $dateFrom->format('Y-m-d') ?>" min=<?php echo $dateFrom->format('Y-m-d') ?> required >
      </div>
      <div>
    <h5 style="margin-left:10px;"> Hasta </h5>
      <input type="date" id="dateTo" name="dateTo" value="<?php echo $dateTo->format('Y-m-d') ?>" min=<?php echo $dateTo->format('Y-m-d')  ?> style="margin-left:10px;">
      <input type="hidden" name="cinemaId" value="<?php echo $cinema->getId()?>">
      </div>
      <button class="btn btn-primary "type="submit" style="margin-left:10px; margin-top: 20px; height:40px;">Buscar</button>
    </div>
    
    </form>
  </div>
</div>
<main class="py-5">

     <section id="listado" class="mb-5">
     
          <div class="container">
          <h2 style="text-align:center; color:white; background:rgba(0, 0, 0, 0.7); widht:50; border-style: solid;"><?php echo 'Cinema '.$cinema->getName() ?></h2>
          <?php  if (isset($_SESSION['userLogin'])){
                                                  $userLogin=$_SESSION['userLogin'];
                                                  if($userLogin->getUserRole()==1){
                                                   ?>   
               <form style="text-align:center" method="post" id="columnarForm">
                                              
               <button type="submit" name="cinemaId" class="btn btn-success" value="<?php echo $cinemaId ?>" onclick="submitFormMovie('<?php echo FRONT_ROOT ?>Function/showAddView')"> Add Function</button>
               
               <input type="hidden" name="auditoriumId" value="0" class="form-control">
               </form>
               <?php } }?>
               
              <?php
                if(isset($message) && $message!=1){ 
              ?> 
                <div class="movieSelect" style="display:block; align-items: center; text-align: center; max-width:500">
                  <h5 style="color:white; background:rgba(0, 0, 0, 0.7); widht:50;"> <?php echo $message; ?> </h5>
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
        var form = document.getElementById('genreForm');        
        form.action = action;
        form.submit();
    }

    function submitFormMovie(action)
    {
        var form = document.getElementById('columnarForm');
        form.action = action;
        form.submit();
    }
</script>