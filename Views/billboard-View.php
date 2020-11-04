<?php
    require_once('nav-auditorium.php');
    require_once('Config\Autoload.php');
    

    use Models\Auditorium as Auditorium;
    use DAO\AuditoriumDAO as AuditoriumDAO;
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
               <table class="table bg-light-alpha">
              
               <form method="post" id="columnarFormMovie">
               
               <?php foreach($moviesList as $key => $res){  ?>              
               
              <div class="movieDiv" onclick="submitFormMovie('<?php echo FRONT_ROOT ?>Function/ShowFunctions')">
              <input type="hidden" name="cinemaId" value="<?php echo $cinemaId ?>" class="form-control">
              <input type="hidden" name="auditoriumId" value="0" class="form-control">
              <?php echo 'ID: '.$res->getId().'<br>' ?>
              <input type="hidden" name="idMovie" value="<?php echo $res->getId(); ?>" class="form-control">
              
                <div width="30%">
                  <img src=<?php echo IMAGE_ROOT. $res->getPosterPath();?>> </img>
                </div>
                <div class="textDiv">
                  <h4 ><?php echo $res->getTitle();'<br>' ;?></h4>
                  <p><?php echo $res->getOverview();'<br>' ;?></p>
                  <h5>Genres:</h5>
                  </form> 
                </div>
              </div>
              <div style ="maheight:250"></div>
            <?php } ?>
               </table>
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