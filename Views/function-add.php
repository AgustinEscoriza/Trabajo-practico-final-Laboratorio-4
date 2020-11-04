<?php
    require_once('nav-function.php');
?>
                        
<main class="py-5">
    <section id="listado" class="mb-5">
        <div class="container" style="text-align:center;">            
            <h2 class="mb-4" style="color:white; background:rgba(0, 0, 0, 0.7); widht:50;">Generate New Function</h2>                
            <form action="<?php echo FRONT_ROOT ?>Function/Add" method="post" class="add-form bg-light-alpha p-5">
                                                                                                         
                <div>
                <div class="col-lg-4">
                        <div class="form-group">
                            <label for="">Auditorium</label>
                            <div class="movieSelect">   
                            <input type="hidden" name="cinemaId" value="<?php echo $cinemaId ?>" class="form-control"> 
                                <?php if(count($auditoriumsList)>1) { ?>                                           
                                <select name="auditoriumId" id="auditoriumId">
                                    <option type="submit" name="auditoriumId" value="0">Select Auditorium</option>
                                    <?php foreach($auditoriumsList as $auditorium){   ?>  
                                    <div>      
                                        <option type="submit" name="auditoriumId" id="" value=<?php echo $auditorium->getId(); ?>>
                                            <?php echo $auditorium->getName(); ?> 
                                        </option>
                                    </div>
                                    <?php } ?>
                                </select>
                                    <?php } else { ?>                                    
                                        <input type="hidden" name="auditoriumId" value="<?php echo $auditorium->getId()?>" class="form-control">
                                        <h3><?php echo $auditorium->getName()?></h3>
                                        <?php } ?>
                            </div>
                        </div> 
                    </div>         

                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="">Movie</label>
                            <div class="movieSelect">                                      
                                <select name="movieId" id="movieId">
                                    <option type="submit" name="movieId" value="0">Select Title</option>
                                    <?php foreach($moviesList as $movie){   ?>  
                                    <div>      
                                        <option type="submit" name="movieId" id="" value=<?php echo $movie->getId(); ?>>
                                            <?php echo $movie->getTitle(); ?> 
                                        </option>
                                    </div>
                                    <?php } ?>
                                </select>
                            </div>
                        </div> 
                    </div>                     
                        <div class="col-lg-4" style="display:flex;">
                            <div class="form-group">
                                <label for="">Date</label>
                                <input style="width:175px" name="date"  class="form-control" type="date" id="date" value="<?php echo $date->format('Y-m-d') ?>" min=<?php echo $date->format('Y-m-d') ?> required>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Time</label>
                                    <input style="width:175px" name="time"  class="form-control" type="time" id="time" value="" required>
                                </div>
                            </div>          
                        </div>              
                    </div>                                                                
                <div class ="row">
                        <?php
                        if(isset($addMessage)){
                        echo $addMessage;
                        }                        
                        ?>   
                </div>
            
                <button type="submit" name="button" class="btn btn-dark ml-auto d-block">Add</button>
            </form>
        </div>
    </section>

<script>
    function submitForm(action)
    {
        var form = document.getElementById('columnarForm');
        form.action = action;
        form.submit();
    }
</script>