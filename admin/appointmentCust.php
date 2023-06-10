<?php
session_start();
include('../connection/connection.php');
if(isset($_SESSION["adminID"]))
{
	$id = $_SESSION["adminID"];
	
	
}
else{
	header('Location: ../indexAd.php');
}

if(isset($_GET['packageID']) && isset($_GET['status']) && isset($_GET['ordersID']))
{
	$packageIDs = $_GET['packageID']; 
	$status = $_GET['status'];
	$ordersID = $_GET['ordersID'];

	mysqli_query($conn,"UPDATE appointment_detail SET status='$status'  WHERE ordersID='$ordersID'");
	
	
	if($status =="Approve")
	{
		mysqli_query($conn,"UPDATE orders SET adminID = '$id' WHERE ordersID='$ordersID'");
	}
	
		if($status =="Cancel")
	{
		mysqli_query($conn,"UPDATE orders SET adminID = '$id' WHERE ordersID='$ordersID'");
	}
	
	header("Location: appointmentCust.php");
	
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
	
	<title>Appointment</title>
</head>
	
<body>
	
	<?php include('headerAdmin.php'); ?>
	

	<br><br><br><br><br><br>
	<h2 class="txt1" style="text-align: center">CUSTOMER APPOINTMENT</h2>    
	<br>
	<div class="container">
		<table class="table table-hover text-center">
			<thead class="table-dark">
				<tr style="font-size: 17px">
					<th scope="col">NO.</th>
					<th scope="col">ORDER ID</th>
					<th scope="col">NAME</th>
					<th scope="col">TELEPHONE NUMBER</th>
					<th scope="col">PACKAGE DETAIL</th>	
					<th scope="col">STATUS</th>	
					<th scope="col">ACTION </th>				
				</tr>
			</thead>
			<tbody>
			<?php
	
			$ret = mysqli_query($conn,"SELECT o.ordersID, c.customerName, c.telephone, d.status, p.packageID, GROUP_CONCAT(CONCAT(p.packageName, ' (Quantity: ', d.quantity, ', Appointment Date: ', d.appointmentDate, ')') SEPARATOR '<br>') as package_details FROM orders o
			INNER JOIN customer c ON o.customerID = c.customerID
			INNER JOIN appointment_detail d ON o.ordersID = d.ordersID
			INNER JOIN package p ON d.packageID = p.packageID
			WHERE status != 'Approve' GROUP BY o.ordersID ORDER BY o.ordersID");

			$i=1;
		   
			if(mysqli_num_rows($ret)>0){
				while ($row=mysqli_fetch_assoc($ret)){
					?>
					<tr style="font-size: 17px">
						<td><?php echo $i++ ?></td>
						<td><?php echo $row['ordersID'] ?></td>
						<td><?php echo $row['customerName'] ?></td>
						<td><?php echo $row['telephone'] ?></td>
						<td style="text-align:start;"><?php echo $row['package_details'] ?></td>
						<td><?php echo $row['status'] ?></td>
						<td>
						<select  id="statusSelect" onChange="status_update(this.options[this.selectedIndex].value, '<?php echo $row['packageID'] ?>', '<?php echo $row['ordersID'] ?>')">
						<option value="">Update Status</option>	
						<option value="Approve">Approve</option>
						<option value="Cancel">Cancel</option>
						</select>
						</td>

					</tr>
					<?php
				}
			}
			?>
			</tbody>
		</table>								
	</div>
	<script type="text/javascript">
		function status_update(value, packageID, ordersID) 
		{
    		if (confirm("Do you want to " + value + "?")) 
			{
				let url = "http://localhost/petGrooming/admin/appointmentCust.php";
				window.location.href = url + "?packageID=" + packageID + "&status=" + value + "&ordersID=" + ordersID;
    		} else {
        		// Set the selected index back to 0
				document.getElementById("statusSelect").selectedIndex = 0;
    		}
		}
	</script>
	<!--bootsrap-->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>
