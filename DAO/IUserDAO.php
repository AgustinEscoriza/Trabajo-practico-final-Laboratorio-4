<?php
    namespace DAO;

    use Models\User as User;

    interface IUserDAO
    {
        function Add(User $user);
        //function getAll();
        //function update(User $user);
        //function delete(User $user);
    }
?>