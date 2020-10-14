<?php
    namespace DAO;

    use Models\Cine as Cine;

    interface IDAO
    {
        function Add($object);
        function getAll();
        function delete($id);
    }
?>