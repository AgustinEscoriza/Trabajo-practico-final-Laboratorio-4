<?php
    namespace Models;

    class Lenguage{

        private $iso_639_1;
        private $name;        

        public function getIso(){return $this->iso_639_1;}
        public function setIso ($iso_639_1){$this->iso_639_1 = $iso_639_1;}
        public function getName (){return $this->name;}
        public function setName ($name){$this->name = $name;}
    }
?>