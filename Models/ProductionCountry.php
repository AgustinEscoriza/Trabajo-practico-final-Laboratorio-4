<?php
    namespace Models;

    class ProductionCountry{

        private $iso_3166_1;
        private $name;

        public function getIso (){return $this->iso_3166_1;}
        public function setIso ($iso_3166_1){$this->iso_3166_1 = $iso_3166_1;}
        public function getName (){return $this->name;}
        public function setName ($name){$this->name = $name;}       
    }
?>