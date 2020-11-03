<link rel="stylesheet" href="../Views/css/movies-list.css">
<?php
require_once('nav.php');
require_once('Config\Autoload.php');
?>

<div class="movieSelect" style="display:block; align-items: center; text-align: center; max-width:500">
  <h3 style="color:white; background:rgba(0, 0, 0, 0.7); widht:50;">Genero:</h3>
  <form method="post" id="genreForm">

    <select name="genreSelector" id="genreSelector"  onclick="submitForm('<?php echo FRONT_ROOT ?>Movie/filter')" >
      <option type="submit" name="genreSelector" value="0">Todos</option>
        <?php foreach($genresList as $genre){   ?>  
        <div >     
          <option type="submit" name="genreSelector" id="" value=<?php echo $genre->getId(); ?>  ?>
            <?php echo $genre->getName(); ?> 
          </option>
          </div>
        <?php } ?>
    </select>
  </form>
</div>


<div class="filter">
  <?php foreach($moviesList as $key => $res){  ?>
              <div class="movieDiv" <?php echo 'onclick="hola(11)"'?>>
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
  <?php } ?>
</div>            
<?php 
    echo "<div id='demo'></div>"; 
?> 

<script type=text/javascript>
function submitForm(action)
    {      
        var form = document.getElementById('genreForm');
        form.action = action;
        form.submit();
    }
</script>

