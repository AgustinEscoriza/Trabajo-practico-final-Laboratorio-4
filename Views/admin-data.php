<?php
    if(isset($_SESSION["userLogin"])) { 
      $userAdmin = $_SESSION["userLogin"];
      if($userAdmin->getUserRole()!=1){
        echo  "<script> alert ('debe loguearse'); </script>";
        require_once(VIEWS_PATH."user-Login.php");
      }
    require_once('nav.php');
    }
?>
<main class="d-flex">
          <div id="sidebar-container" class="bg-primary">
          <div class="menu">
          <a href="<?php echo FRONT_ROOT ?>User/getUsersList" class="d-block p-3 text-light">Users </a>
          <a href="<?php echo FRONT_ROOT ?>User/showStatisticsTotalSold" class="d-block p-3 text-light">Statistics: Total Sold </a>
          <a href="<?php echo FRONT_ROOT ?>User/showStatisticsRemaining" class="d-block p-3 text-light">Statistics: Remaining Tickets </a>
          </div>
          </div>
 </main>