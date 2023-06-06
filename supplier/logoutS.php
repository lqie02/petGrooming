<?php
 session_start(); 
 unset($_SESSION['supplierID']);
 unset($_SESSION['supplierName']);
 unset($_SESSION['companyName']);
 unset($_SESSION['s_address']);
 unset($_SESSION['s_email']);
 unset($_SESSION['s_telephone']);
 unset($_SESSION['s_password']);
 unset($_SESSION['adminID']);
 //unset($_SESSION['Active_Time']);
 session_destroy();
 header("Location: ../indexAd.php");
exit;

?>