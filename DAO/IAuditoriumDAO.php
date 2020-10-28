<?php
    namespace DAO;

    use Models\Auditorium as Auditorium;

    interface IAuditoriumDAO
    {
        function Add(Auditorium $auditorium,$idCinema);
        function modify($cinemaId,$name,$capacity,$ticketValue);
        function delete($id);
    }
?>