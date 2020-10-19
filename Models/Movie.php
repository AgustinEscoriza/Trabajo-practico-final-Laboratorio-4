<?php
    namespace Models;

    Use Genre as genre;
    Use Lenguage as Lenguage;
    Use ProductionCompany as ProductionCompany;
    Use ProductionCountry as ProductionCountry;

    class Movie{

        private $id;
        private $imdb_id;
        private $adult;
        private $backdrop_path;
        private $belongs_to_collection;
        private $budget;
        private $genreId;
        private $homepage;
        private $original_language;
        private $original_title;
        private $overview;
        private $popularity;
        private $poster_path;
        private $production_companies; // OBJ
        private $production_countries; // OBJ
        private $release_date;
        private $revenue;
        private $runtime;
        private $spoken_languages; // OBJ
        private $status;
        private $tagline;
        private $title;
        private $video;
        private $vote_average;
        private $vote_count;   

        public function __construct()
        {
            $this->genreId = array();

        }
    
        public function getId (){return $this->id;}
        public function setId ($id){$this->id = $id;}
        public function getImdbId (){return $this->imdb_id;}
        public function setImdbId ($imdb_id){$this->imdb_id = $imdb_id;}
        public function getAdult (){return $this->adult;}
        public function setAdult ($adult){$this->adult = $adult;}
        public function getBackdropPath (){return $this->backdrop_path;}
        public function setBackdropPath ($backdrop_path){$this->backdrop_path = $backdrop_path;}
        public function getBelongsToCollection (){return $this->belongs_to_collection;}
        public function setBelongsToCollection ($belongs_to_collection){$this->belongs_to_collection = $belongs_to_collection;}
        public function getBudget (){return $this->budget;}
        public function setBudget ($budget){$this->budget = $budget;}
        public function getHomePage (){return $this->homepage;}
        public function setHomePage ($homepage){$this->homepage = $homepage;}
        public function getGenreId (){return $this->genreId;}
        public function setGenreId ($genreId){array_push($this->genreId, $genreId);}
        public function getOriginalLanguage (){return $this->original_language;}
        public function setOriginalLanguage ($original_language){$this->original_language = $original_language;}
        public function getOriginalTitle (){return $this->original_title;}
        public function setOriginalTitle ($original_title){$this->original_title = $original_title;}
        public function getOverview (){return $this->overview;}
        public function setOverview ($overview){$this->overview = $overview;}
        public function getPopularity (){return $this->popularity;}
        public function setPopularity ($popularity){$this->popularity = $popularity;}
        public function getPosterPath (){return $this->poster_path;}
        public function setPosterPath ($poster_path){$this->poster_path = $poster_path;}
        public function getReleaseDate (){return $this->release_date;}
        public function setReleaseDate ($release_date){$this->release_date = $release_date;}
        public function getRevenue (){return $this->revenue;}
        public function setRevenue ($revenue){$this->revenue = $revenue;}
        public function getRuntime (){return $this->runtime;}
        public function setRuntime ($runtime){$this->runtime = $runtime;}
        public function getStatus (){return $this->status;}
        public function setStatus ($status){$this->status = $status;}
        public function getTagline (){return $this->tagline;}
        public function setTagline ($tagline){$this->tagline = $tagline;}
        public function getTitle (){return $this->title;}
        public function setTitle ($title){$this->title = $title;}
        public function getVideo (){return $this->video;}
        public function setVideo ($video){$this->video = $video;}
        public function getVoteAverage (){return $this->vote_average;}
        public function setVoteAverage ($vote_average){$this->vote_average = $vote_average;}
        public function getVoteCount (){return $this->vote_count;}
        public function setVoteCount ($vote_count){$this->vote_count = $vote_count;}
        public function setGenreName($key,$value){ $this->genreId[$key] = $value;}
        
    }
?>