<link rel="stylesheet" href="../Views/css/movies-list.css">
<?php
require_once('nav.php');
require_once('Config\Autoload.php');
?>

<div class="movieSelect" style="display:block; align-items: center; text-align: center; max-width:500">
  <h3 style="color:white; background:rgba(0, 0, 0, 0.7); widht:50;">Genero:</h3>
  <form action="<?php echo FRONT_ROOT ?>Movie/filter" method="post">

    <select name="genreSelector" id="genreSelector">
      <option type="submit" name="genreSelector" value="0">Todos</option>
        <?php foreach($genresList as $genre){   ?>       
          <option type="submit" name="genreSelector" id="" value=<?php echo $genre->getId(); ?> href="<?php echo FRONT_ROOT ?>Movie/filter(<?php echo $genre->getId(); ?>)">
            <?php echo $genre->getName(); ?> 
          </option>
        <?php } ?>
    </select>
      <button type="submit" name="button" class="btn btn-primary">Filter</button>
  </form>
</div>



<?php



    
   
    foreach($moviesList as $key => $res){   
            ?>
            <div class="movieDiv" >
              <div width="30%">
                <img src=<?php echo IMAGE_ROOT. $res->getPosterPath();?>> </img>
              </div>
              <div class="textDiv">
                <h4 ><?php echo $res->getTitle();'<br>' ;?></h4>
                <p><?php echo $res->getOverview();'<br>' ;?></p>
                <h5>Genres:</h5>
                <?php foreach($res->getGenre() as $genre) { ?>
                <p>  <?php echo $genre;'<br>' ;?> </p>
                <?php } ?>
              </div>
            </div>
            <div style ="maheight:250"></div>
            <?php
              
            
        
    }

    
 
?>
<?php 
    echo "<div id='demo'></div>"; 
?> 
<script type="text/JavaScript"> 
  
// Function is called, return  
// value will end up in x 
var x = myFunction(11, 10);    
document.getElementById("demo").innerHTML = x; 
  
// Function returns the product of a and b 
function myFunction(a, b) { 
    return a * b;              
} 
</script> 

