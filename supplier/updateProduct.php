<?php
session_start();
include('../connection/connection.php');

if(isset($_SESSION["adminID"])) 
{
	$id = $_SESSION["adminID"];

} else 
{
	// Redirect if not logged in
	header('Location: ../indexAd.php');
	exit();
}

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		// Get the submitted form data
		$productID = $_POST['productID'];
		$productName = $_POST['productName'];
		$cName = $_POST['cName'];
		$stockQuantity = $_POST['stockQuantity'];
		$p_unitPrice = $_POST['p_unitPrice'];
		$d_description = $_POST['d_description'];

		// Update the product information in the database
		$sql = "UPDATE package SET productName = '$productName', categoryID = '$cName', stockQuantity = '$stockQuantity', p_unitPrice = '$p_unitPrice' , d_description = '$d_description'  WHERE productID = '$productID'";
		$result = mysqli_query($conn, $sql);

		// Check if the update was successful
		if ($result) {
			// Check if a new image was uploaded
			if ($_FILES['productImage']['name']) {
				$imageName = $_FILES['productImage']['name'];
				$imageTmpName = $_FILES['productImage']['tmp_name'];

				// Process the uploaded image
				$imageData = addslashes(file_get_contents($imageTmpName)); // Addslashes to handle special characters

				// Update the image in the database
				$sql = "UPDATE product SET p_image = '$imageData' WHERE productID = '$productID'";
				$result = mysqli_query($conn, $sql);

				// Check if the image update was successful
				if ($result) 
				{
					// Image update successful
					echo "<script>alert('Product information and image have been updated successfully');</script>";
					echo"<meta http-equiv='refresh' content='0; url=managePro.php'/>";
				} 
				else 
				{
					// Image update failed
					echo "<script>alert('Error updating the product image: " . mysqli_error($conn) . "');</script>";
					echo "<meta http-equiv='refresh' content='0; url=managePro.php'/>";
				}
			} 
			else 
			{
				// Image was not uploaded, only package information was updated
				echo "<script>alert('Product information has been updated successfully');</script>";
				echo"<meta http-equiv='refresh' content='0; url=managePro.php'/>";
			}
		} 
		else 
		{
			// Update Product
			echo "<script>alert('Error updating the product information: " . mysqli_error($conn) . "');</script>";
			echo "<meta http-equiv='refresh' content='0; url=managePro.php'/>";
		}
	} 
	else 
	{
		// Invalid request method
		echo "Invalid request method.";
	}

?>
