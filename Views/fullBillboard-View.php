<link rel="stylesheet" href="../Views/css/movies-list.css">
<?php
require_once('nav.php');
require_once('Config\Autoload.php');

?>
<div style="display:flex; width:100%; color:white; background:rgba(0, 0, 0, 0.7); height:120px;">
  <div style="align-items: center; text-align: center; width:50%">
    <h3 style="color:white; background:rgba(0, 0, 0, 0.7); widht:50;">Genero:</h3>
    <form method="post" id="genreForm">
    <input type="hidden" name="cinemaId" value="0">
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

      </div>
      <button class="btn btn-primary "type="submit" style="margin-left:10px; margin-top: 20px; height:40px;">Buscar</button>
    </div>
    </form>
  </div>
</div>

<div>
<?php
                if(isset($message) && $message!=1){ ?> 
                              <div class="movieSelect" style="display:block; align-items: center; text-align: center; max-width:500">
                              <h5 style="color:white; background:rgba(0, 0, 0, 0.7); widht:50;"> <?php echo $message; ?> </h5>

                              <?php }
 foreach($moviesList as $res){ ?>  
<div class="container">
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
      <form method="post" id="columnarFormMovie" action="<?php echo FRONT_ROOT ?>Function/FunctionsToCinema"> 
        <input type="hidden" id="idMovie" name="idMovie" value="<?php echo $res->getId(); ?>" class="form-control">
        <div style="justify-content: flex-end;">
        <button type="submit" name="button" class="btn btn-success">Functions</button>
        </div>
      </form> 
    </div>
  </div>            
</div>


<div style ="maheight:250"></div>
<?php } ?>
</div>            
<?php 
    echo "<div id='demo'></div>"; 
?> 

<script type=text/javascript>
function submitForm(action)
    {      
      if(document.getElementById('genreForm').value!=0){
        var form = document.getElementById('genreForm');
        form.action = action;
        form.submit();
      }
    }
</script>

