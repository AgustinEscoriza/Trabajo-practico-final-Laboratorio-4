<?php
    namespace Models;

    class Billboard{

        private $id;
        private $cinemaId;
        private $functionsList;
        
        public function __construct()
        {
            $this->functionsList = array();
        }

        public function getId(){
            return $this->id;
        }
        public function setId ($id){
            $this->id = $id;
        }

        public function getCinemaId(){
            return $this->cinemaId;
        }

        public function setCinemaId ($cinemaId){
            $this->cinemaId = $cinemaId;
        }     
        
        public function getFunctionsList(){
            return $this->functionsList;
        }

        public function addFunctionToList ($function){
            array_push($this->functionsList, $function);
        }     
    }
?>