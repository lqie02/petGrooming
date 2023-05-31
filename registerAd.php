<?php
include("connection/connection.php");
session_start();


if($_SERVER['REQUEST_METHOD'] == "POST"){
	function test_input($data) 
	{
  		$data = trim($data);
 		$data = stripslashes($data);
  		$data = htmlspecialchars($data);
  		return $data;
	}

	$adminName = test_input($_POST['adminName']);
	$adminEmail = test_input($_POST['adminEmail']);
	$adminTelephone = test_input($_POST['adminTelephone']);
	$adminPassword = test_input($_POST['adminPassword']);
	$cpassword =test_input($_POST['cpassword']);

	$query = mysqli_query($conn,"SELECT DISTINCT * FROM admin WHERE LCASE(adminEmail) = '" . $adminEmail . "'");

    if($query->num_rows)
	{
        echo "<script>alert('Email address already exist in database please login');</script>";
    }
	elseif($adminPassword != $cpassword)
	{
		echo "<script>alert('Two passwords that enter do not match');</script>";
		echo"<meta http-equiv='refresh' content='0; url=registerAd.php'/>";
	}
	else 
	{

        mysqli_query($conn,"INSERT INTO admin SET adminName = '" . $adminName."', adminEmail = '" . $adminEmail . "', adminTelephone ='".$adminTelephone."', adminPassword ='".md5($adminPassword)."'");
		// echo($conn->query($query));
		// exit();
		if(mysqli_insert_id($conn))
		{
			echo "<script>alert('Sucessfully register! Please proceed to login.');</script>";
			echo"<meta http-equiv='refresh' content='0; url=indexAd.php'/>";
		}
		else
		{
			echo "<script>alert('Registration fail! Please try again.');</script>";
			echo"<meta http-equiv='refresh' content='0; url=registerAd.php'/>";
		}
	}
}
else
{
	$adminName = '';
	$adminEmail = '';
	$adminTelephone = '';
    $adminPassword = '';
    $cpassword = '';

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<link rel="shortcut icon" type="image/png" href="image/pets.png">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="css/registerCust.css"> <!--css-->
	<title>Abby Shop</title>
	
</head>
<body>
	<?php include('headerAd.php');?>
	<div class="container">
		<form action="" method="POST" class="login-email">
            <p class="login-text" style="font-size: 2rem; font-weight: 800;">Admin Register</p>
			<div class="input-group">
				<input type="text" placeholder=" Name" name="adminName" value="<?php echo $adminName; ?>" required>
			</div>
			<div class="input-group">
				<input type="email" placeholder="Email" name="adminEmail" value="<?php echo $adminEmail; ?>" required>
			</div>
			<div class="input-group">
				<input type="text" placeholder="Telephone" name="adminTelephone" value="<?php echo $adminTelephone; ?>" required>
			</div>
			<div class="input-group">
				<input pattern=".{8,}" type="password" placeholder="Password" name="adminPassword"  value="<?php echo $adminPassword; ?>" required title="8 characters minimum">
            </div>
            <div class="input-group">
				<input pattern=".{8,}" type="password" placeholder="Confirm Password" name="cpassword" value="<?php echo $cpassword; ?>" required title="8 characters minimum">
			</div>
			<div class="input-group">
				<button name="submit" class="btn">Register</button>
			</div>
			<p class="login-register-text">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Have an account? <a href="indexAd.php">Login Here</a>.</p>
		</form>
	</div>
</body>
</html>