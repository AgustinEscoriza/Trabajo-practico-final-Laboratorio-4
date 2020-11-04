<link rel="stylesheet" href="../Views/css/function-list.css">
<?php
require_once('nav.php');
require_once('Config\Autoload.php');
//.' '.$function->getDate()->format('d').', '.$function->getTime()->format('H:i:s') ;
?>


<div class="filter">
            <div class="functionDiv">
                <div width="80%">
                    <img src=<?php echo IMAGE_ROOT.$movie[0]->getPosterPath();?>> </img>
                </div>
                <div class="">
                    <h4 ><?php echo $movie[0]->getTitle();'<br>' ;?></h4>
                    <p><?php echo $movie[0]->getOverview();'<br>' ;?></p>
                    <h5>Duration: <?php echo $movie[0]->getRuntime().' Minutes<br>' ;?></h5>
                    <h5>Genres:</h5>
                    <?php foreach($movie[0]->getGenre() as $genre) { ?>
                    <p>  <?php echo $genre;'<br>' ;?> </p>
                    <?php } ?>
                    <h5>Functions:</h5>
                    <?php foreach($functionsList as $function) { 
                        $day = date('l',strtotime($function->getDate()));
                        $dayNumber = date('d',strtotime($function->getDate()));
                        $time = date('H:i:s',strtotime($function->getTime()));
                        ?>

                    <p>  <?php echo $day.' '.$dayNumber.', '.$time.' HS'?> </p>
                    <?php } ?>
                </div>
            </div>
        <div style ="maheight:250"></div>
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

