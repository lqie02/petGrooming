<?php
 session_start(); 
 unset($_SESSION['adminID']);
 unset($_SESSION['adminName']);
 unset($_SESSION['adminEmail']);
 unset($_SESSION['adminTelephone']);
 unset($_SESSION['adminPassword']);

 //unset($_SESSION['Active_Time']);
 session_destroy();
 header("Location: ../indexAd.php");
exit;

?>