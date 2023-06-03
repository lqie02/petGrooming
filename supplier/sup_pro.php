<?php
session_start();
include('../connection/connection.php');
if(isset($_SESSION["supplierID"]))
{
	$id= $_SESSION["supplierID"];
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
	
	<title>Manage Product</title>
	<style>
	.image
	{
		width: 150px; 
    	height: 150px; 
	}
	.toast-container 
	{
       display: flex;
       justify-content: center;
       align-items: flex-start;
       margin-left: 100px;
	   background-color: red;
       
    }

    .toast 
	{
        max-width: none;
        width: auto;
    }
	 .bold-product-name 
	{
        font-weight: bold;
    }
	.low-stock-row 
	{
   		background-color: #ffcccc; /* Set the red background color */
  	}
	</style>
</head>
	
<body>
	
	<?php include("headerSup.php") ?>
	
	<div class="container">
		<br><br><br><br><br><br>
		<a href="addPro.php" class="btn btn-dark">Add New Product</a>
		<br><br><br><br>
			<table class="table table-bordered" style="border-color: black;">
			  <thead class="table-info" style="border-color: black;">
				<tr>
				  <th scope="col" class="text-center">ID</th>
				  <th scope="col">PRODUCT NAME</th>
				  <th scope="col"><center>IMAGE</center></th>
				  <th scope="col"><center>CATEGORY</center></th>
				  <th scope="col"><center>STOCK QUANTITY</center></th>
				  <th scope="col"><center>PRICE (RM)</center></th>
				  <th scope="col"><center>DESCRIPTION</center></th>
				  <th scope="col">ACTION</th>
				</tr>
			  </thead>
			  <tbody>
				  <?php
				  	$sql = "SELECT * FROM product p JOIN category c ON p.categoryID = c.categoryID JOIN supplier s ON p.supplierID = s.supplierID WHERE s.supplierID = '$id'";
				  	$result = mysqli_query($conn,$sql);
				  	while($row = mysqli_fetch_assoc($result))
					{ ?>
				  		<tr>
						  <th><?php echo $row['productID'] ?></th>
						  <th ><?php echo $row['productName'] ?></th>
						  <th><?php echo '<img class="image" src="data:image/jpeg;base64,'.base64_encode($row['pro_image']).'" />'; ?></th>
						  <th><center><?php echo $row['cName'] ?></center></th>
						  <th><center><?php echo $row['stockQuantity'] ?></center></th>
						  <th><center><?php echo $row['p_unitPrice'] ?></center></th>
						  <th><?php echo $row['d_description'] ?></th>
						  <td>
							  <center>
								  <a href="#" class="link-dark" data-bs-toggle="modal" data-bs-target="#productModal<?php echo $row['productID']; ?>">
									  <i class="fa-solid fa-pen-to-square fs-5 me-3"></i>
								  </a>
							  </center>
						  </td>
						</tr>
				  		<!-- Package Modal -->
						<div class="modal fade" id="productModal<?php echo $row['productID']; ?>" tabindex="-1" aria-labelledby="productModalLabel<?php echo $row['productID']; ?>" aria-hidden="true">
							<div class="modal-dialog modal-dialog-centered">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="productModalLabel<?php echo $row['productID']; ?>"><b>Edit Product Information</b></h5>
										<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
									</div>
									<div class="modal-body">
										<!-- Edit package form goes here -->
									<form action="updateProduct.php" method="POST" enctype="multipart/form-data">
									<input type="hidden" name="productID" value="<?php echo $row['productID']; ?>">
										<div class="mb-3">
											<label for="productName" class="form-label">Product Name</label>
											<input type="text" class="form-control" id="productName" name="productName" value="<?php echo $row['productName']; ?>" required>
										</div>
										
										<div class="mb-3">
											<label class="form-label">Category</label><br>
												<div class="form-check form-check-inline">
													<input class="form-check-input" type="radio" name="cName" id="dogRadio" value="7000" <?php echo ($row['cName'] == 'Dog') ? 'checked' : ''; ?>>
													<label class="form-check-label" for="dogRadio">Dog</label>
												</div>
												<div class="form-check form-check-inline">
													<input class="form-check-input" type="radio" name="cName" id="catRadio" value="7001" <?php echo ($row['cName'] == 'Cat') ? 'checked' : ''; ?>>
													<label class="form-check-label" for="catRadio">Cat</label>
												</div>
										</div>

										
										<div class="mb-3">
											<label for="stockQuantity" class="form-label">Stock Quantity</label>
											<input type="text" class="form-control" id="stockQuantity" name="stockQuantity" value="<?php echo $row['stockQuantity']; ?>" required>
										</div>
										
										<div class="mb-3">
											<label for="p_unitPrice" class="form-label">Price</label>
											<input type="text" class="form-control" id="p_unitPrice" name="p_unitPrice" value="<?php echo $row['p_unitPrice']; ?>" required>
										</div>
										
										<div class="mb-3">
											<label for="d_description" class="form-label">Description</label>
											<textarea class="form-control" id="d_description" name="d_description" required><?php echo $row['d_description']; ?></textarea>
										</div>
										
										
									
										
										<div class="mb-3">
											<label for="productImage" class="form-label">Image</label><br>											
												<?php
												 $imageData = base64_encode($row['pro_image']);
												if ($imageData) 
												{
													echo '<img class="image" src="data:image/jpeg;base64,' . $imageData . '" alt="Current Image">';
												}
												?>
												<input type="file" class="form-control" id="productImage" name="productImage">
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
