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

$sql = "UPDATE product_detail SET p_status = 'Cancel' WHERE ordersID = '$orderID'";
if($result = mysqli_query($conn,$sql));
{
	echo "<script>alert('Cancel Successfully!');</script>";
	echo"<meta http-equiv='refresh' content='0; url=orderProHis.php'>";
}

?>
	