<link rel="stylesheet" href="../Views/css/movies-list.css">
<?php
require_once('nav-billboard.php');
require_once('Config\Autoload.php');
?>

<div>
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
                  <p>  <?php echo $genre->getName();'<br>' ;?> </p>
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

