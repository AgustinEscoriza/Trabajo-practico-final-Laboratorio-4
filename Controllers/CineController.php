<?php
    namespace Controllers;

    use DAO\CineDAO as CineDAO;
    use DAO\AuditoriumDAOmysql as AuditoriumDAO;
    use Models\Cine as Cine;

    class CineController{

        private $cineDAO;

        public function __construct(){

            $this->cineDAO = new CineDAO();
            $this->auditoriumDAO = new AuditoriumDAO();
        }

        public function showAddView ($addMessage=""){
            require_once(VIEWS_PATH."cine-add.php");
        }

        public function showListView (){
            
            $cineList = $this->cineDAO->getAll();
    
            require_once(VIEWS_PATH."cine-list.php");
            
        }
        public function showModifyView(){
            
            require_once(VIEWS_PATH."cine-modify.php");
        }

        public function showLoginView(){

            session_destroy();
            require_once(VIEWS_PATH."user-login.php");
        }

        public function Add($name, $adress)
        {
            $cine = new Cine();
            $cine->setName($name);
            $cine->setAdress($adress);

            $this->showAddView($this->cineDAO->Add($cine));;
        }

        

        public function Modify($cineId)
        {            
            $cine = $this->cineDAO->getCinema($cineId);
            $this->cineDAO->delete($cineId);
            require_once(VIEWS_PATH."cine-modify.php");
        }

    }
?>