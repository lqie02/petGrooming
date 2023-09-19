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
	$packageName = $_POST['packageName'];
	$animalType = $_POST['animalType'];
	$unitPrice = $_POST['unitPrice'];
	$description = $_POST['description'];
	
	$insert_image = $_FILES['image']['name'];
  	$insert_image_size = $_FILES['image']['size'];
  	$insert_image_tmp_name = $_FILES['image']['tmp_name'];
	
	if(!empty($insert_image))
	{
     	if($insert_image_size > 100000)
	 	{
          echo "<script>alert('Failed to insert!');</script>";
          echo "<script>window.location.href ='addPack.php'</script>";
     	}
		else
		{
			$image = addslashes(file_get_contents($insert_image_tmp_name)); 
			
			$query = "INSERT INTO package(packageName, animalType, unitPrice, description, p_image, avgRating,adminID) VALUES ('$packageName', '$animalType', '$unitPrice', '$description', '$image', '0', '$id' )";

			$res = mysqli_query($conn,$query);

			if($res)
			{
				echo "<script>alert('Insert successfully');</script>";
				echo"<meta http-equiv='refresh' content='0; url=managePack.php'/>";
			}
			else
			{
				echo "Failed: " .mysqli_error($conn);
			}
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
	
	<title>Add Pacakge</title>
</head>
	<body>
		<?php include('headerAdmin.php'); ?>
	<br><br>
		<div class= "container">
		<div class="text-center mb-4"><br><br><br>
			<h3>Add Pacakge Information</h3>
			<p class="text-muted">Complete the form to add a new package</p>		
		</div>
			<div class="container d-flex justify-content-center">
			<form action="" method="post" style="width:50vw; min-width:300px;" enctype="multipart/form-data" >
				<div class="row">
					<div class="cal">
						<label class="form-label">Pacakge Name : </label>
						<input type="text" class="form-control" name="packageName" placeholder="Dog Shower" required>
					</div>
					
					<div class="cal"><br>
						<label class="form-label">Unit Price : </label>
						<input type="number" class="form-control" name="unitPrice" min="1" placeholder="RM xxx.xx" required>
					</div>
					
					<div class="cal"><br>
						<label class="form-label">Description : </label>
						<textarea class="form-control" id="description" name="description" placeholder="" required></textarea>
						
					</div>
					
					<div class="cal"><br>
						<label>Select Category :</label><br>
						<input type="radio" name="animalType" value="Dog" required> Dog &nbsp;&nbsp;&nbsp;&nbsp;
				   		<input type="radio" name="animalType" value="Cat" required> Cat
					</div>
					
					<div class="cal"><br>
						<label class="form-label">Image : </label>
						<input type="file" class="form-control" name="image" placeholder="" required>
					</div>	
					
					<div><br>
						<button type="submit" class="btn btn-success" name="submit">&nbsp;Save&nbsp;</button>&nbsp;
						<a href="managePack.php" class="btn btn-danger">Cancel</a>
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