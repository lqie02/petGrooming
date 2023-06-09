<?php
session_start();
include('../connection/connection.php');

if (isset($_SESSION["adminID"])) {
  $adminID = $_SESSION["adminID"];
} else {
  header('Location: ../indexAd.php');
}


?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="shortcut icon" type="image/png" href="../image/pets.png">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!--Bootstrap-->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<!--font Awesome-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<title>Sales Report</title>
</head>

<body>
</body>
</html>