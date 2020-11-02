<?php
    namespace Models;

    use Models\Movie as Movie;
    use Models\Auditorium as Auditorium;
    use \DateTime as NewDT;

    class Functions{

        private $id;
        private $auditorium;
        private $date;
        private $tickets; //contador de tickets vendidos
        private $runtime;
        private $movie;
        
        public function __construct(){
            $this->date = new NewDT();
        }


        public function getId(){
            return $this->id;
        }
        public function setId ($id){
            $this->id = $id;
        }
        public function getTickets(){
            return $this->tickets;
        }
        public function setTickets ($tickets){
            $this->tickets = $tickets;
        }

        public function getAuditorium(){
            return $this->auditorium;
        }
        public function setAuditorium (Auditorium $auditorium){
            $this->auditorium = $auditorium;
        }
        
        public function getDate(){
            return $this->date;
        }

        public function setDate ($date){
            $this->date = $date;
        }       

        public function getTime(){
            return $this->time;
        }

        public function setTime($time){
            $this->time = $time;
        }       
        
        public function getMovie(){
            return $this->movie;
        }

        public function setMovie (Movie $movie){
            $this->movie = $movie;
        }    
    }
?>