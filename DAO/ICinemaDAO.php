<?php
    namespace DAO;

    use Models\Cinema as Cinema;

    interface ICinemaDAO
    {
        function Add(Cinema $cinema);
        function getAll();
        //function update(Cinema $cinema);
        function delete(Cinema $cinema);
    }
?>