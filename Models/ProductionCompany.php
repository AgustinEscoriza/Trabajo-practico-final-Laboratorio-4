<?php
    namespace Models;

    class ProductionCompany{

        private $id;
        private $logo_path;
        private $name;
        private $origin_country;

        public function getId (){return $this->id;}
        public function setId ($id){$this->id = $id;}
        public function getLogo_path (){return $this->logo_path;}
        public function setLogo_path ($logo_path){$this->logo_path = $logo_path;}
        public function getName (){return $this->name;}
        public function setName ($name){$this->name = $name;}       
        public function getOrigin_country (){return $this->origin_country;}
        public function setOrigin_country ($origin_country){$this->origin_country = $origin_country;}
    }
?>