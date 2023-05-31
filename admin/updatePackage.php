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
		$packageID = $_POST['packageID'];
		$packageName = $_POST['packageName'];
		$animalType = $_POST['animalType'];
		$unitPrice = $_POST['unitPrice'];
		$description = $_POST['description'];

		// Update the package information in the database
		$sql = "UPDATE package SET packageName = '$packageName', animalType = '$animalType', unitPrice = '$unitPrice', description = '$description' , adminID = '$id'  WHERE packageID = '$packageID'";
		$result = mysqli_query($conn, $sql);

		// Check if the update was successful
		if ($result) {
			// Check if a new image was uploaded
			if ($_FILES['packageImage']['name']) {
				$imageName = $_FILES['packageImage']['name'];
				$imageTmpName = $_FILES['packageImage']['tmp_name'];

				// Process the uploaded image
				$imageData = addslashes(file_get_contents($imageTmpName)); // Addslashes to handle special characters

				// Update the image in the database
				$sql = "UPDATE package SET p_image = '$imageData' WHERE packageID = '$packageID'";
				$result = mysqli_query($conn, $sql);

				// Check if the image update was successful
				if ($result) 
				{
					// Image update successful
					echo "<script>alert('Package information and image have been updated successfully');</script>";
					echo"<meta http-equiv='refresh' content='0; url=managePack.php'/>";
				} 
				else 
				{
					// Image update failed
					echo "<script>alert('Error updating the package image: " . mysqli_error($conn) . "');</script>";
					echo "<meta http-equiv='refresh' content='0; url=managePack.php'/>";
				}
			} 
			else 
			{
				// Image was not uploaded, only package information was updated
				echo "<script>alert('Package information has been updated successfully');</script>";
				echo"<meta http-equiv='refresh' content='0; url=managePack.php'/>";
			}
		} 
		else 
		{
			// Update failed
			echo "<script>alert('Error updating the package information: " . mysqli_error($conn) . "');</script>";
			echo "<meta http-equiv='refresh' content='0; url=managePack.php'/>";
		}
	} 
	else 
	{
		// Invalid request method
		echo "Invalid request method.";
	}

?>
