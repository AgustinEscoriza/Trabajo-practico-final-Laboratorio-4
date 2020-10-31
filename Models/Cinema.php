<?php
    namespace Models;

    class Cinema{

        private $id;
        private $name;
        private $adress;
        private $billboard;


        public function __construct(){
            
        }

        public function getId (){
            return $this->id;
        }
        public function setId ($id){
            $this->id = $id;
        }

        public function getName (){
            return $this->name;
        }

        public function setName ($name){
            $this->name = $name;
        }

        public function getAdress (){
            return $this->adress;
        }

        public function setAdress ($adress){
            $this->adress = $adress;
        }

        public function getBillboard (){
            return $this->billboard;
        }

        public function setBillboard (Billboard $billboard){
            $this->billboard = $billboard;
        }
        
    }
?>