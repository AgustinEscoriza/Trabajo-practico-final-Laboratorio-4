<?php
namespace DAO;

    use DAO\MovieDAO as MovieDAO;
    use Models\Cinema as Cinema;
    use Models\Movie as Movie;
    use Models\Genre as Genre;
    use Models\Lenguage as Lenguage;
    use Models\ProductionCompany as ProductionCompany;
    use Models\ProductionCountry as ProductionCountry;  

class MovieDAO
{    
    private $moviesList = array();
    private $genresList = array();

    function display_array($array){
    foreach($array as $key => $res){   
        if(is_array($res)){
              display_array($res);
          } 
          else
          {
              echo $key.': '.$res.'<br>' ;
          } 
        }
    }

    function getMovie($id){
        $resp = file_get_contents(API_ROOT.MOVIE_PATH.$id.API_KEY);
        
    return json_decode($resp, true);
    }

    function getNowPlayingMovies(){
        $resp = file_get_contents(API_ROOT.MOVIE_PATH.MOVIE_NOW_PLAYING.API_KEY);

        $this->moviesToObject($resp);

        return $this->moviesList;
    }

    function moviesToObject($moviesInJSON)
    {
        $this->moviesList = array();

        $movies = json_decode($moviesInJSON, true);

        foreach($movies["results"] as $movie)
        {
            $newMovie = new Movie();
            $newMovie->setTitle($movie["title"]);
            $newMovie->setId($movie["id"]);
            foreach($movie["genre_ids"] as $genre)
            {
                $newMovie->setGenreId($genre);
            }
            $newMovie->setPosterPath($movie["poster_path"]);
            $newMovie->setOverview($movie["overview"]);

            array_push($this->moviesList,$newMovie);
        }
    }

    function getGenres(){
        $resp = file_get_contents(LIST_ROOT.API_KEY);

        $this->genresToObject($resp);

        return $this->genresList;
    }

    function genresToObject($genresInJSON)
    {
        $this->genresList = array();

        $genres = json_decode($genresInJSON, true);

        foreach($genres["genres"] as $genre)
        {
            $newGenre = new Genre();
            $newGenre->setId($genre["id"]);
            $newGenre->setName($genre["name"]);
            

            array_push($this->genresList,$newGenre);
        }
    }
}
?>

