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