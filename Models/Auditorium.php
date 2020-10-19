<?php
    namespace Models;

    class Auditorium{

        private $id;
        private $name;
        private $capacity;
        private $ticketValue;


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

        public function getCapacity (){
            return $this->capacity;
        }

        public function setCapacity ($capacity){
            $this->capacity = $capacity;
        }

        public function getTicketValue (){
            return $this->ticketValue;
        }

        public function setTicketValue ($ticketValue){
            $this->ticketValue = $ticketValue;
        }

        
    }
?>