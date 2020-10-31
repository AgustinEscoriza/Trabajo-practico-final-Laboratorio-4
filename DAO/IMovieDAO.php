<?php
    namespace DAO;

    use Models\Movie as Movie;

    interface IMovieDAO
    {
        function display_array($array);
        function getMovie($id);
        function getNowPlayingMovies();
        function moviesToObject($moviesInJSON);
        function getGenres();
        function genresToObject($genresInJSON);
    }
?>