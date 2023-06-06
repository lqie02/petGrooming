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

if(isset($_GET['status']) && isset($_GET['ordersID']))
{
	$status = $_GET['status'];
	$ordersID = $_GET['ordersID'];

	mysqli_query($conn,"UPDATE product_detail SET p_status='$status'  WHERE ordersID='$ordersID'");
	
	
	if($status =="Drop Point")
	{
	mysqli_query($conn,"UPDATE orders SET adminID = '$id' WHERE ordersID='$ordersID'");}
	
	
	header("Location: orderCust.php");
	
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
	
	<title>Order</title>
</head>
	
<body>
	
	<?php include('headerAdmin.php'); ?>
	

	<br><br><br><br><br><br>
	<h2 class="txt1" style="text-align: center">CUSTOMER ORDER</h2>    
	<br>
	<div class="container">
		<table class="table table-hover text-center">
			<thead class="table-dark">
				<tr style="font-size: 17px">
					<th scope="col">NO.</th>
					<th scope="col">ORDER ID</th>
					<th scope="col">NAME</th>
					<th scope="col">TELEPHONE NUMBER</th>
					<th scope="col">ADDRESS</th>
					<th scope="col">STATUS</th>	
					<th scope="col">ACTION </th>
					<th scope="col">DETAIL </th>
				</tr>
			</thead>
			<tbody>
			<?php
	
			$ret = mysqli_query($conn,"SELECT * FROM orders o
			INNER JOIN customer c ON o.customerID = c.customerID
			INNER JOIN product_detail d ON o.ordersID = d.ordersID
			WHERE p_status != 'Drop Point' GROUP BY o.ordersID ORDER BY o.ordersID");

			$i=1;
		   
			if(mysqli_num_rows($ret)>0){
				while ($row=mysqli_fetch_assoc($ret)){
					?>
					<tr style="font-size: 17px">
						<td><?php echo $i++ ?></td>
						<td><?php echo $row['ordersID'] ?></td>
						<td><?php echo $row['customerName'] ?></td>
						<td><?php echo $row['telephone'] ?></td>
						<td><?php echo $row['cAddress'] ?></td>
						<td><?php echo $row['p_status'] ?></td>
						<td>
						<select  id="statusSelect" onChange="status_update(this.options[this.selectedIndex].value, '<?php echo $row['ordersID'] ?>')">
						<option value="">Update Status</option>	
						<option value="Accept">Accept</option>
						<option value="Drop Point">Drop Point</option>
						</select>
						</td>
						<td>
          				<a href="custOrderDetail.php?id=<?php echo $row['ordersID'] ?>" class="link-dark" style="text-decoration: none;"><i class="fa fa-download"></i>&nbsp;Details</a>
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
		function status_update(value,  ordersID) 
		{
    		if (confirm("Do you want to " + value + "?")) 
			{
				let url = "http://localhost/petGrooming/admin/orderCust.php";
				window.location.href = url + "?status=" + value + "&ordersID=" + ordersID;
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
