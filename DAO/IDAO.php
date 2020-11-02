<?php
    namespace DAO;

    interface IDAO
    {
        function Add($object);
        function getAll();
        function delete($id);
    }
?>