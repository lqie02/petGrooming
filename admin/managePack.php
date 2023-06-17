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
	
	<title>Manage Package</title>
	<style>
		.image
		{
			width: 150px; 
    		height: 150px; 
		}
	</style>
</head>
	
<body>
	
	<?php include("headerAdmin.php") ?>
	
	<div class="container">
		<br><br><br> <br><br>
		<h2><center>Package</center></h2>
		<a href="addPack.php" class="btn btn-dark">Add New Package</a>
		<a href="review.php" class="btn btn-dark" style="margin-left: 10px">Package Review</a>
		<br><br>
			<table class="table table-bordered" style="border-color: black;">
			  <thead class="table-info" style="border-color: black;">
				<tr>
				  <th scope="col" class="text-center">ID</th>
				  <th scope="col">PACKAGE NAME</th>
				  <th scope="col"><center>IMAGE</center></th>
				  <th scope="col"><center>CATEGORY</center></th>
				  <th scope="col"><center>PRICE (RM)</center></th>
				  <th scope="col"><center>DESCRIPTION</center></th>
				  <th scope="col">ACTION</th>
				</tr>
			  </thead>
			  <tbody>
				  <?php
				  	$sql = "SELECT * FROM package ORDER BY CASE WHEN animalType = 'Dog' THEN 1 WHEN animalType = 'Cat' THEN 2 END";
				  	$result = mysqli_query($conn,$sql);
				  	while($row = mysqli_fetch_assoc($result))
					{ ?>
				  		<tr>
						  <th><?php echo $row['packageID'] ?></th>
						  <th ><?php echo $row['packageName'] ?></th>
						  <th><?php echo '<img class="image" src="data:image/jpeg;base64,'.base64_encode($row['p_image']).'" />'; ?></th>
						  <th><center><?php echo $row['animalType'] ?></center></th>
						  <th><center><?php echo $row['unitPrice'] ?></center></th>
						  <th><?php echo $row['description'] ?></th>
						<td>
  							<div style="display: flex; justify-content: center;">
   							 <a href="#" class="link-dark" data-bs-toggle="modal" data-bs-target="#packageModal<?php echo $row['packageID']; ?>">
      						<i class="fa-solid fa-pen-to-square fs-5 me-3"></i></a>
    						<a href="deletePack.php?packageID=<?php echo $row['packageID'] ?>" onclick="return confirm('Are you sure you want to delete this package?')">
  							<i class="fa fa-trash fs-4 me-3" style="color: red"></i></a>
  							</div>
						</td>

						</tr>
				  		<!-- Package Modal -->
						<div class="modal fade" id="packageModal<?php echo $row['packageID']; ?>" tabindex="-1" aria-labelledby="packageModalLabel<?php echo $row['packageID']; ?>" aria-hidden="true">
							<div class="modal-dialog modal-dialog-centered">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="packageModalLabel<?php echo $row['packageID']; ?>"><b>Edit Package Information</b></h5>
										<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
									</div>
									<div class="modal-body">
										<!-- Edit package form goes here -->
									<form action="updatePackage.php" method="POST" enctype="multipart/form-data">
									<input type="hidden" name="packageID" value="<?php echo $row['packageID']; ?>">
										<div class="mb-3">
											<label for="packageName" class="form-label">Package Name</label>
											<input type="text" class="form-control" id="packageName" name="packageName" value="<?php echo $row['packageName']; ?>" required>
										</div>
										
										<div class="mb-3">
											<label class="form-label">Animal Type</label><br>
												<div class="form-check form-check-inline">
													<input class="form-check-input" type="radio" name="animalType" id="dogRadio" value="Dog" <?php echo ($row['animalType'] == 'Dog') ? 'checked' : ''; ?>>
													<label class="form-check-label" for="dogRadio">Dog</label>
												</div>
												<div class="form-check form-check-inline">
													<input class="form-check-input" type="radio" name="animalType" id="catRadio" value="Cat" <?php echo ($row['animalType'] == 'Cat') ? 'checked' : ''; ?>>
													<label class="form-check-label" for="catRadio">Cat</label>
												</div>
										</div>

										
										<div class="mb-3">
											<label for="unitPrice" class="form-label">Price</label>
											<input type="text" class="form-control" id="unitPrice" name="unitPrice" value="<?php echo $row['unitPrice']; ?>" required>
										</div>
										
										<div class="mb-3">
											<label for="description" class="form-label">Description</label>
											<textarea class="form-control" id="description" name="description" required><?php echo $row['description']; ?></textarea>
										</div>
										
										<div class="mb-3">
											<label for="packageImage" class="form-label">Image</label><br>											
												<?php
												 $imageData = base64_encode($row['p_image']);
												if ($imageData) 
												{
													echo '<img class="image" src="data:image/jpeg;base64,' . $imageData . '" alt="Current Image">';
												}
												?>
												<input type="file" class="form-control" id="packageImage" name="packageImage">
										</div>

										
										<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
												<button type="submit" class="btn btn-primary">Save changes</button>
										</div>
									</form>
									</div>
								</div>
							</div>
						</div>
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
