<?php
include("../connection/connection.php");
session_start();
if(isset($_SESSION["customerID"]))
{
	$id= $_SESSION["customerID"];
	
}
else{
	header('Location: ../index.php');
}

$sql = "SELECT * FROM package WHERE animalType = 'Cat'";
$result = $conn->query($sql);


?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
<link rel="shortcut icon" type="image/png" href="../image/pets.png">
<link rel="stylesheet" type="text/css" href="../css/dashboard.css">
<title>Abby Shop</title>
</head>

<body>
	<?php include('headerCust.php');?>
	<main>
	<?php 
		while($row = mysqli_fetch_assoc($result)) {
			echo "<form method='post' action='addCart.php'>"; // open form for each package
	?>
		<div class="card"> 
			<div class="image">
				<?php echo '<img src="data:image/jpeg;base64,'.base64_encode($row['p_image']).'"  />'; ?>
			</div>
			<div class="caption">
				<p class="package_name"><b><?php echo $row["packageName"] ?></b></p>
				<p class="price"><b>Price : RM <?php echo $row["unitPrice"] ?></b></p>
				<p class="price"><b>Description :</b></p>
				<p class="price"><?php echo $row["description"] ?></p>
				<input type='hidden' name='packageID' value='<?php echo $row["packageID"] ?>'/>
				<input type='hidden' name='unitPrice' value='<?php echo $row["unitPrice"] ?>'/>
				<input type='hidden' name='packageName' value='<?php echo $row["packageName"] ?>'/>	
				<p class="price" >Quantity :<input type="number" name="quantity" id="quantity" value="0" min="0" class="form-control" ></p>
				<p class="price" for="appointmentDate" >Appointment Date :<input type="datetime-local" name="appointmentDate" class="form-control">

				<button class="add" type="submit" name="add_to_cart">Add to Cart</button>
			</div>
		</div>
		</form> <!-- close form for each package -->
		<?php } ?>
</main>

	
</body>
</html>