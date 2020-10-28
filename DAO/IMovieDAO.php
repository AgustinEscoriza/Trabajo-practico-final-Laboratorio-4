<?php
    namespace DAO;

    use Models\Movie as Movie;

    interface IMovieDAO
    {
        function Add(Movie $movie);
        function getAll();
        function modify(Movie $movie);
        function delete($id);
    }
?>