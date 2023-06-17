<?php
session_start();
include('../connection/connection.php');
if(isset($_SESSION["adminID"]))
{
	$id= $_SESSION["adminID"];
}
else{
	header('Location: ../indexAd.php');
}

?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" type="png" href="#"> <!--icon-->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="../css/try.css">
</head>

<body>
<header>
	
	<a href="#" class="logo">Abby Shop</a>
	<input type="checkbox" id="menu-bar">
	<label for="menu-bar">Menu</label>
	<nav class="navbar">
    <ul> 
		<li><a href="homepage.php">Home</a></li>
        <li><a href="managePack.php">Package</a></li>
        <li><a href="managePro.php">Product</a></li>
		<li><a href="manageSup.php">Supplier</a></li>
		<li><a href="#">Customer</a>
			<ul>
                <li><a href="appointmentCust.php">Appointment</a></li>
                <li><a href="orderCust.php">Order</a></li>
            </ul>
		</li>
        <li><a href="#">Sales Report</a>
			<ul>
				<li><a href="ratingPack.php">Rating</a></li>
                <li><a href="salesPack.php">Package</a></li>
                <li><a href="salesPro.php">Product</a></li>
            </ul>
		</li>
        <li><a href="logoutA.php">Logout</a></li>
    </ul>
</nav>
</header>


</body>
</html>