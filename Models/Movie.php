<?php
    namespace Models;

    Use Genre as Genre;

    class Movie{

        private $id;
        private $genre;             //array
        private $original_title;
        private $original_language;
        private $overview;
        private $poster_path;
        private $release_date;
        private $runtime;
        private $spoken_languages; // Array
        private $status;
        private $title;
        

        public function __construct()
        {
            $this->genre = array();
            $this->spoken_languages = array();
        }
    
        public function getId (){return $this->id;}
        public function setId ($id){$this->id = $id;}
        public function getGenre (){return $this->genre;}
        public function setGenre ($genre){array_push($this->genre, $genre);}
        public function getOriginalTitle (){return $this->original_title;}
        public function setOriginalTitle ($original_title){$this->original_title = $original_title;}
        public function getOriginalLanguage (){return $this->original_language;}
        public function setOriginalLanguage ($original_Language){$this->original_language = $original_Language;}
        public function getOverview (){return $this->overview;}
        public function setOverview ($overview){$this->overview = $overview;}
        public function getPosterPath (){return $this->poster_path;}
        public function setPosterPath ($poster_path){$this->poster_path = $poster_path;}
        public function getReleaseDate (){return $this->release_date;}
        public function setReleaseDate ($release_date){$this->release_date = $release_date;}
        public function getRuntime (){return $this->runtime;}
        public function setRuntime ($runtime){$this->runtime = $runtime;}
        public function getStatus (){return $this->status;}
        public function setStatus ($status){$this->status = $status;}
        public function getTitle (){return $this->title;}
        public function setTitle ($title){$this->title = $title;}
        public function setGenreName($key,$value){ $this->genre[$key] = $value;}
        
    }
?>