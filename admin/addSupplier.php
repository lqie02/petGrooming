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

if(isset($_POST['submit']))
{
		$supplierName = $_POST['supplierName'];
		$companyName = $_POST['companyName'];
		$s_address = $_POST['s_address'];
	    $s_email = $_POST['s_email'];
		$s_telephone = $_POST['s_telephone'];
		$password = $_POST['s_password'];
		$cpassword =$_POST['cpassword'];
		
	
	if($password != $cpassword)
	{
		echo "<script>alert('Two passwords that enter do not match');</script>";
		echo"<meta http-equiv='refresh' content='0; url=addSupplier.php'/>";
	} 
	else
	{
		$password = md5($password);
		$query = "INSERT INTO supplier(supplierName, companyName, s_address, s_email,s_telephone,s_password,adminID) VALUES ('$supplierName', '$companyName', '$s_address', '$s_email', '$s_telephone', '$password', '$id' )";

		$res = mysqli_query($conn,$query);

		if($res)
		{
			echo "<script>alert('Insert successfully');</script>";
			echo"<meta http-equiv='refresh' content='0; url=manageSup.php'/>";
		}
		else
		{
			echo "Failed: " .mysqli_error($conn);
		}
	}
}
?>


<!doctype html>
<html lang="en" dir="ltr">
<head>
<meta charset="utf-8">
	<link rel="shortcut icon" type="image/png" href="../image/pets.png">
    
	<!--Bootstrap-->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<!--font Awesome-->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
	
	<title>Add Supplier</title>
</head>
	<body>
		<?php include('headerAdmin.php'); ?>
	<br><br>
		<div class= "container">
		<div class="text-center mb-4"><br><br><br>
			<h3>Add Supplier Information</h3>
			<p class="text-muted">Complete the form to add a new supplier</p>		
		</div>
			<div class="container d-flex justify-content-center">
			<form action="" method="post" style="width:50vw; min-width:300px;">
				<div class="row">
					<div class="cal">
						<label class="form-label">Name : </label>
						<input type="text" class="form-control" name="supplierName" placeholder="John">
					</div>
					
					<div class="cal"><br>
						<label class="form-label">Company Name : </label>
						<input type="text" class="form-control" name="companyName" placeholder="John Sdn Bhd">
					</div>
						
					<div class="cal"><br>
						<label class="form-label">Email : </label>
						<input type="text" class="form-control" name="s_email" placeholder="example@gmail.com">
					</div>
					
					<div class="cal"><br>
						<label class="form-label">Telephone : </label>
						<input type="text" class="form-control" name="s_telephone" placeholder="+60 1xxxxxxxx">
					</div>
					
					<div class="cal"><br>
						<label class="form-label">Address : </label>
						<input type="text" class="form-control" name="s_address" placeholder="state city postcode">
					</div>
						
					<div class="cal"><br>
						<label class="form-label">Password : </label>
						<input pattern=".{8,}" type="password" class="form-control" name="s_password" placeholder="*********" required title="8 characters minimum">
					</div>
					
					<div class="cal"><br>
						<label class="form-label">Comfirm Password : </label>
						<input pattern=".{8,}" type="password" class="form-control" name="cpassword" placeholder="*********" required title="8 characters minimum">
					</div>
					
					
					<div><br>
						<button type="submit" class="btn btn-success" name="submit">&nbsp;Save&nbsp;</button>&nbsp;
						<a href="manageSup.php" class="btn btn-danger">Cancel</a>
					</div>
					<div><br></div>
				  </div>
			 	</form>
			</div>
		</div>
		
		<!--bootsrap-->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
	</body>
</html>