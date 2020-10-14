<?php
    namespace DAO;

    use Models\Cine as Cine;

    interface ICineDAO
    {
        function Add($object);
        function getAll();
        function delete($id);
    }
?>