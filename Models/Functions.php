<?php
    namespace Models;

    use Models\Movie as Movie;
    use \DateTime as NewDT;

    class Functions{

        private $id;
        private $date;
        private $time;
        private $movieId;
        
        public function __construct(){
            $this->date = new NewDT();
        }


        public function getId(){
            return $this->id;
        }
        public function setId ($id){
            $this->id = $id;
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
        
        public function getMovieId(){
            return $this->movieId;
        }

        public function setMovieId ($movieId){
            $this->movieId = $movieId;
        }    
    }
?>