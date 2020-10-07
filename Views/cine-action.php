<?php
     require_once("Config/Autoload.php");

     use Models\Cine as Cine;
     use DAO\CineDAO as CineDAO;

     session_start();

        if($_POST){
           
            var_dump($_POST);
            $id = $_POST['id'];
            $name = $_POST['name'];
            $adress = $_POST['adress'];
            $capacity =$_POST['capacity'];
            $ticketValue = $_POST['ticketValue'];

            $cine = new Cine();
            $cine->setId($id);
            $cine->setTitle($name);
            $cine->setauthor($adress);
            $cine->setGenre($capacity);
            $cine->setFormat($ticketValue);

            $cineRepo = new CineDAO();
            $validate = $cineRepo->Add($cine);

            if($validate === false){
               // header("location:add-form.php?error");
            }else{
               // header("location:add-form.php?ok");
            }
            
                

        }

?>