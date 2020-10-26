<?php
    namespace DAO;

    use Models\Auditorium as Auditorium;

    interface IAuditoriumDAO
    {
        function Add(Auditorium $auditorium);
        function getAll();
        //function update(Auditorium $auditorium);
        function delete(Auditorium $auditorium);
    }
?>