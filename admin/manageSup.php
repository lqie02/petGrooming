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
<html lang="en" dir="ltr">
<head>
<meta charset="utf-8">
	<link rel="shortcut icon" type="image/png" href="../image/pets.png">
    
	<!--Bootstrap-->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
   <!--font Awesome-->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
	
	<title>Manage Supplier</title>
</head>
	
<body>
	
	<?php include("headerAdmin.php") ?>
	
	<div class="container">
		<br><br><br><br><br><br>
		<a href="addSupplier.php" class="btn btn-dark">Add New Supplier</a>
		<br><br><br><br>
			<table class="table table-hover text-center">
			  <thead class="table-dark">
				<tr>
				  <th scope="col">ID</th>
				  <th scope="col">NAME</th>
				  <th scope="col">COMPANY NAME</th>
				  <th scope="col">EMAIL</th>
				  <th scope="col">TELEPHONE</th>
				  <th scope="col">ADDRESS</th>
				  <th scope="col">ACTION</th>
				</tr>
			  </thead>
			  <tbody>
				  <?php
				  	$sql = "SELECT * FROM supplier WHERE adminID = '$id'";
				  	$result = mysqli_query($conn,$sql);
				  	while($row = mysqli_fetch_assoc($result))
					{ ?>
				  		<tr>
						  <th><?php echo $row['supplierID'] ?></th>
						  <th><?php echo $row['supplierName'] ?></th>
						  <th><?php echo $row['companyName'] ?></th>
						  <th><a href="mailto:<?php echo $row['s_email']; ?>"><?php echo $row['s_email']; ?></a></th>
						  <th><a href="tel:+6<?php echo $row['s_telephone']; ?>"><?php echo $row['s_telephone'] ?></th>
						  <th><?php echo $row['s_address'] ?></th>
						  <td>
							  <a href="editInfo.php?supID=<?php echo $row['supplierID'] ?>" class="link-dark"><i class="fa-solid fa-pen-to-square fs-5 me-3"></i></a>
						  </td>
						</tr>
				  		<?php
					}
				  ?>
				
			  </tbody>
	</table>
	
	</div>
	
	<!--bootsrap-->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
	
</body>
</html>