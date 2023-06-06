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

$sql = "SELECT * FROM product WHERE categoryID = 7001";
$result = $conn->query($sql);


?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link rel="shortcut icon" type="image/png" href="../image/pets.png">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
<link rel="stylesheet" type="text/css" href="../css/product.css">
<title>Abby Shop</title>
</head>

<body>
	<?php include('headerCust.php');?>
	
	<p style="margin-top: 120px; "><center><b style="font-size: 25px;">DOG GROOMING</b></center></p>
	
	<main>
	<?php 
		while($row = mysqli_fetch_assoc($result)) {
			echo "<form method='post' action='addCartPro.php'>"; // open form for each product
	?>
		<div class="card"> 
			<div class="image">
				<?php echo '<img src="data:image/jpeg;base64,'.base64_encode($row['pro_image']).'"  />'; ?>
			</div>
			<div class="caption">
				<p class="productName"><b><?php echo $row["productName"] ?></b></p>
				<p class="price"><b>Price : RM <?php echo $row["p_unitPrice"] ?></b></p>
				<p class="price"><b>Stock Quantity :  <?php echo $row["stockQuantity"] ?></b></p>
				<p class="price"><b>Description :</b></p>
				<p class="price"><?php echo $row["d_description"] ?></p>
				<input type='hidden' name='productID' value='<?php echo $row["productID"] ?>'/>
				<input type='hidden' name='unitPrice' value='<?php echo $row["p_unitPrice"] ?>'/>
				<input type='hidden' name='productName' value='<?php echo $row["productName"] ?>'/>	
				<p class="price" >Quantity :<input type="number" name="quantity" id="quantity" value="0" min="0" class="form-control" ></p>
				

				<button class="add" type="submit" name="add_to_cart">Add to Cart</button>
			</div>
		</div>
		</form> <!-- close form for each product -->
		<?php } ?>
</main>

	
</body>
</html>