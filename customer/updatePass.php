<?php
include("../connection/connection.php");
session_start();
if(isset($_SESSION["customerID"]))
{
  $id= $_SESSION["customerID"];
	
	if((time()-$_SESSION['Active_Time'])>300)
	{
		header('Location:../index.php');
	}
	else
	{
		$_SESSION['Active_Time'] = time();
	}
}
else{
  header('Location: ../index.php');
}

if(isset($_POST['reset']))
{
	 $customer_query = mysqli_query($conn, "UPDATE customer SET  password = '" . md5($_POST['password']) . "' WHERE customerID ='$id' ");
	
  	// Check if the update was successful
  	if ($customer_query) {
		// Trigger the refresh meta tag and display success message
    	echo '<script>alert("Update password successful!");</script>';
		echo '<meta http-equiv="refresh" content="0;url=profile.php">';
  	} else {
    	// Display error message if the update failed
   		die('Update failed: ' . mysqli_error($conn));
  	}
}


?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<link rel="shortcut icon" type="image/png" href="../image/pets.png">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="../css/index.css"> <!--css-->
	<title>Abby Shop</title>
	
</head>
<body>

  <div class="container">
    <form action="" method="POST" class="login-email">
      <p align="center" class="login-text" style="font-size: 2rem; font-weight: 800;">Reset Password</p>
      <br>
        <p align="justify">Please enter the new password : </p><br>

		<div class="input-group">
        <input pattern=".{8,}" type="password" placeholder="Password" name="password"  value="<?php echo $password; ?>" required title="8 characters minimum"></div><br>

          <div class="input-group">
          <button name="reset" class="btn">Reset Password</button>
          </div>

        </div>
      </form>
    </form>
  </section>
</body>
</html>