<?php
    require_once('nav.php');
    require_once('Config\Autoload.php');
    

    use Models\Auditorium as Auditorium;
    use DAO\AuditoriumDAO as AuditoriumDAO;
?>
<link rel="stylesheet" href="../Views/css/movies-list.css">
<main class="py-5">
     <section id="listado" class="mb-5">
     <div class="movieSelect" style="display:block; align-items: center; text-align: center; max-width:500">
      <h3 style="color:white; background:rgba(0, 0, 0, 0.7); widht:50;">Genero:</h3>
      <form action="<?php echo FRONT_ROOT ?>Billboard/showFilteredListGenre" method="post">

        <select name="genreSelector" id="genreSelector">
          <option type="submit" name="genreSelector" value="0">Todos</option>
            <?php foreach($genresList as $genre){   ?>       
              <option type="submit" name="genreSelector" id="" value=<?php echo $genre->getId(); ?> href="<?php echo FRONT_ROOT ?>Movie/showFilteredListGenre<?php echo $genre->getId(); ?>)">
                <?php echo $genre->getName(); ?> 
              </option>
            <?php } ?>
        </select>
          <button type="submit" name="button" class="btn btn-primary">Filter</button>
      </form>
    </div>

          <div class="container">
          <br>
            <?php foreach ($moviesList as $movie) { ?>
            <table class="table table-striped table-dark">
                <thead class="thead-dark">
                    <tr>
                        <th style="width: 20%;"></th>
                        <th style="width: 25%;">Movie</th>
                        <th style="width: 35%;">Overview</th>
                        <th style="width: 10%;">Language</th>
                        <th style="width: 10%;">Genre</th>
                        <th style="width: 10%;">Runtime</th>
                        <th style="width: 1%;"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td> <?php echo '<img src="https://image.tmdb.org/t/p/w220_and_h330_face/' . $movie->getPosterPath() . '">' ?>
                        </td>
                        <td> <?php echo $movie->getTitle(); ?> </td>
                        <td> <?php echo $movie->getOverview(); ?> </td>
                        <td> <?php echo $movie->getOriginalLanguage(); ?> </td>
                        <?php $genres = $this->getGenresByMovieId($movie->getId()); ?>
                        <td><?php foreach ($genres as $value) {
                                    echo $value->getName() . " ";
                                }
                                ?></td>
                        <td> <?php echo $movie->getRuntime(); ?> </td>
                        <td></td>
                </tbody>
                <?php } ?>
            </table>
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
</script>