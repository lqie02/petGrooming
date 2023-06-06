<?php
session_start();
include('../connection/connection.php');
if(isset($_SESSION["customerID"]))
{
  $id= $_SESSION["customerID"];
  
}
else{
  header('Location: ../index.php');
}
$orderID = $_GET['id'];
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="shortcut icon" type="image/png" href="../image/pets.png">

<!--Bootstrap-->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<!--font Awesome-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
<title>Abby Shop</title>
	<style>
		.image
		{
			width: 150px; 
    		height: 150px; 
		}
	</style>
</head>

<body>
	<?php include('headerCart.php'); ?>
	
	<div class="container">
	<h1 style="margin-top: 100px;"><center>Feedback</center></h1><br>
	<p><center>Are you satisfied with our service? Please provide a rating and comment. </center></p>
	<table  class="table table-bordered" style="border-color: black;">
		<thead class="table-primary" style="border-color: black;">
			<tr>
				<th scope="col" >Grooming Package</th>
				<th scope="col" >Rate</th>
				<th scope="col" >Comment</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$sql = "SELECT * FROM appointment_detail a, package p WHERE a.packageID = p.packageID AND a.ordersID = '$orderID'";
				$result = mysqli_query($conn,$sql);
				
				while($row = mysqli_fetch_assoc($result))
				{ ?>
					<tr>
						<th><?php echo $row['packageName'] ?>
						<br>
							<?php echo '<img class="image" src="data:image/jpeg;base64,'.base64_encode($row['p_image']).'" />'; ?>
						</th>
						<th>
							<form>+</form>
						</th>
						
			
			
					</tr>
			<?php
				}
			?>
		</tbody>
	</table>
	</div>
	
</body>
</html>