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
                    <?php
                           if(isset($infoMessage)){
                           echo $infoMessage;
                           }
                         ?>  
                    <?php if (!empty($functionsList)) { foreach($functionsList as $function) { 
                        $day = date('l',strtotime($function->getDate()));
                        $dayNumber = date('d',strtotime($function->getDate()));
                        $time = date('H:i:s',strtotime($function->getTime()));
                        ?>
                    <form method="post" id="genreForm<?php echo $function->getId()?>">
                    <div name="functionSelectior" id="functionSelectior"  onclick="submitForm('<?php echo FRONT_ROOT ?>Ticket/buyTicketView',<?php echo $function->getId() ?>)" > 
                    <input type="hidden" name="idFunction" value="<?php echo $function->getId()?>">
                    </form> 
                       <p> <?php echo $day.' '.$dayNumber.', '.$time.' HS'?> </p>
                    </div>
                    <?php } 
                    }
                    else
                    { 
                        if (!empty($functionsByCinemaList)) { 
                            foreach($functionsByCinemaList as $cinema) { 
                        ?> <h3>  <?php echo $cinema["cinemaName"]?> </h3> <?php
                                if(!empty($cinema["functions"])){
                                    
                                    foreach($cinema["functions"] as $function){
                                    $day = date('l',strtotime($function->getDate()));
                                    $dayNumber = date('d',strtotime($function->getDate()));
                                    $time = date('H:i:s',strtotime($function->getTime()));
                                    
                                    ?>  
                                    <form method="post" id="genreForm<?php echo $function->getId()?>">
                                    <div name="functionSelectior" id="functionSelectior"  onclick="submitForm('<?php echo FRONT_ROOT ?>Ticket/buyTicketView',<?php echo $function->getId() ?>)" > 
                                    <input type="hidden" name="idFunction" value="<?php echo $function->getId()?>">
                                    <input type="hidden" name="function" value="<?php echo $function?>">
                                    <!-- esta ultima linea la puse para mandar la funcion completa, fijate si la toma asi para evitar una query mas ala base-->
                                    </form> 
                                    <p> <?php echo $day.' '.$dayNumber.', '.$time.' HS'?> </p>
                                    </div>
                                    <?php
                                    }
                                }
                                if(isset($cinema["disponibility"])){
                                    echo $cinema["disponibility"];
                                    } 
                                
                         } } }?>
                </div>
            </div>
        <div style ="maheight:250"></div>
</div>            
<?php 
    echo "<div id='demo'></div>"; 
?> 

<script type=text/javascript>
function submitForm(action,num)
    {      

        var form = document.getElementById('genreForm'+num);
        form.action = action;
        form.submit();
    }
</script>

