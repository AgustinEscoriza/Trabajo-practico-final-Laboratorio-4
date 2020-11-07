<link rel="stylesheet" href="../Views/css/movies-list.css">
<?php
   use Controllers\UserController as UserController;
   $userController = new UserController();
   $userController->userCheck();
   require_once('nav-user.php');
require_once('nav-billboard.php');
require_once('Config\Autoload.php');
?>

<div class="movieSelect" style="display:block; align-items: center; text-align: center; max-width:500">
  <h3 style="color:white; background:rgba(0, 0, 0, 0.7); widht:50;">NUEVAS PELICULAS:</h3>
</div>
<?php
if(isset($movieMessage))
{
  echo '<h3 style="text-align: center; color:white; background:rgba(0, 0, 0, 0.7); widht:50;">'.$movieMessage.'</h3>';
}
?>
<div>
  <?php if(count($moviesList)>0){ foreach($moviesList as $key => $res){  ?>
              <div class="movieDiv" <?php echo 'onclick="hola(11)"'?>>
                <div width="30%">
                  <img src=<?php echo IMAGE_ROOT. $res->getPosterPath();?>> </img>
                </div>
                <div class="textDiv">
                  <h4 ><?php echo $res->getTitle();'<br>' ;?></h4>
                  <p><?php echo $res->getOverview();'<br>' ;?></p>
                  
                </div>
              </div>
              <div style ="maheight:250"></div>
  <?php }} ?>
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

