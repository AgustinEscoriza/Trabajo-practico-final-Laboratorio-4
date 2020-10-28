<?php
    namespace DAO;

    use Models\Cinema as Cinema;

    interface ICinemaDAO
    {
        function Add(Cinema $cinema);
        function getAll();
        function modify($cinemaId,$name,$adress);
        function delete($id);
    }
?>