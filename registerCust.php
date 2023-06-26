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

	$customerName = test_input($_POST['customerName']);
	$email = test_input($_POST['email']);
	$telephone = test_input($_POST['telephone']);
	$cAddress = test_input($_POST['cAddress']);
	$password = test_input($_POST['password']);
	$cpassword =test_input($_POST['cpassword']);

	$query = mysqli_query($conn,"SELECT DISTINCT * FROM customer WHERE LCASE(email) = '" . $email . "'");

    if($query->num_rows)
	{
        echo "<script>alert('Email address already exist in database please login');</script>";
    }
	elseif($password != $cpassword)
	{
		echo "<script>alert('Two passwords that enter do not match');</script>";
		echo"<meta http-equiv='refresh' content='0; url=registerCust.php'/>";
	}
	else 
	{

        mysqli_query($conn,"INSERT INTO customer SET customerName = '" . $customerName."', email = '" . $email . "', telephone ='".$telephone."', cAddress = '" . $cAddress . "', password ='".md5($password)."'");
		// echo($conn->query($query));
		// exit();
		if(mysqli_insert_id($conn))
		{
			echo "<script>alert('Sucessfully register! Please proceed to login.');</script>";
			echo"<meta http-equiv='refresh' content='0; url=index.php'/>";
		}
		else
		{
			echo "<script>alert('Registration fail! Please try again.');</script>";
			echo"<meta http-equiv='refresh' content='0; url=registerCust.php'/>";
		}
	}
}
else
{
	$customerName = '';
	$email = '';
	$telephone = '';
	$cAddress = '';
    $password = '';
    $cpassword = '';

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<link rel="shortcut icon" type="image/png" href="image/pets.png">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="css/index.css"> <!--css-->
	<title>Abby Shop</title>
	
</head>
<body>

	<br><br><br><br>
	<div class="container" >
		<form action="" method="POST" class="login-email">
            <p class="login-text" style="font-size: 2rem; font-weight: 800;">Customer Register</p>
			<div class="input-group">
				<input type="text" placeholder=" Name" name="customerName" value="<?php echo $customerName; ?>" required>
			</div>
			<div class="input-group">
				<input type="email" placeholder="Email" name="email" value="<?php echo $email; ?>" required>
			</div>
			<div class="input-group">
				<input type="text" placeholder="Telephone" name="telephone" value="<?php echo $telephone; ?>" required>
			</div>
			<div class="input-group">
				<input type="text" placeholder="Address" name="cAddress" value="<?php echo $cAddress; ?>" required>
			</div>
			<div class="input-group">
				<input pattern=".{8,}" type="password" placeholder="Password" name="password"  value="<?php echo $password; ?>" required title="8 characters minimum">
            </div>
            <div class="input-group">
				<input pattern=".{8,}" type="password" placeholder="Confirm Password" name="cpassword" value="<?php echo $cpassword; ?>" required title="8 characters minimum">
			</div>
			<div class="input-group">
				<button name="submit" class="btn">Register</button>
			</div>
			<p class="login-register-text">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Have an account? <a href="index.php">Login Here</a>.</p>
		</form>
	</div>
</body>
</html>