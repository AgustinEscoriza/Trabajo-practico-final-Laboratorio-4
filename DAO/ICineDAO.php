<?php
    namespace DAO;

    use Models\Cine as Cine;

    interface ICineDAO
    {
        function Add(Cine $cine);
        function getAll();
        function delete($name);
    }
?>