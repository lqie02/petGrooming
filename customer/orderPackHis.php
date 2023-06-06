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

// Set the default values for the search fields
$package_name = '';
$orderDate = '';

// Get the search values from the form submission
if (isset($_GET['package_name'])) {
  $package_name = $_GET['package_name'];
}

if (isset($_GET['orderDate'])) {
  $orderDate = $_GET['orderDate'];
}

// Set the number of records per page
$records_per_page = 10;

// Get the current page number from the URL
$page_number = isset($_GET['page']) ? $_GET['page'] : 1;

// Calculate the offset value
$offset = ($page_number - 1) * $records_per_page;

// Construct the SQL query with pagination
$sql = "SELECT * FROM orders o 
        INNER JOIN appointment_detail a ON o.ordersID = a.ordersID 
        INNER JOIN package p ON p.packageID = a.packageID 
        WHERE customerID = '$id'";

if (!empty($package_name)) {
  $sql .= " AND p.packageName LIKE '%$package_name%'";
}

if (!empty($orderDate)) {
  // Convert the search date to a datetime range
  $sql .= " AND o.orderDate = '$orderDate'";
}

$sql .= " GROUP BY o.ordersID 
          ORDER BY o.ordersID DESC 
          LIMIT $records_per_page 
          OFFSET $offset";

$result = mysqli_query($conn, $sql);

// Calculate the total number of records
$sql_count = "SELECT COUNT(*) as count FROM orders o 
              INNER JOIN appointment_detail a ON o.ordersID = a.ordersID 
              INNER JOIN package p ON p.packageID = a.packageID 
              WHERE customerID ='$id'";

if (!empty($package_name)) {
  $sql_count .= " AND p.packageName LIKE '%$package_name%'";
}

if (!empty($appointment_date)) {
  $sql_count .= " AND a.appointmentDate = '$appointment_date'";
}

$count_result = mysqli_query($conn, $sql_count);
$count_row = mysqli_fetch_assoc($count_result);
$total_records = $count_row['count'];

// Calculate the total number of pages
$total_pages = ceil($total_records / $records_per_page);

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
	
	<title>Abby Shop</title>
</head>
	
<body> 
	
	<?php include('headerCart.php'); ?>
		
			  <p style="margin-top: 120px; "><center><b style="font-size: 20px;">APPOINTMENT HISTORY</b></center></p>
				<!--<h2 class="txt1">Delivered History</h2>-->     
				<form method="get">
				  <div class="row mb-3" style="margin-left: 90px; margin-top: 50px;">
				    <div class="col-sm-2">
				      <input type="text" class="form-control" placeholder="Package name" name="package_name">
				    </div>
				    <div class="col-sm-2">
				      <input type="date" class="form-control" placeholder="Order date" name="orderDate">
				    </div>
					 

				    <div class="col-sm-4">
					  
				      <button type="submit" class="btn btn-primary">Search</button>
				      <a href="<?php echo $_SERVER['PHP_SELF']; ?>" class="btn btn-secondary" style="margin-left: 10px;">Reset</a>

				    </div>
				  </div>
				</form>
 
			<div class="container" style="margin-top: 50px;">
			<table class="table table-hover text-center">
				 <thead class="table-dark">
				
				<tr>
					<th scope="col">NO.</th>
					<th scope="col">ORDER ID</th>
					<th scope="col">ORDERDATE</th>
					<th scope="col">ORDER STATUS</th>
					<th scope="col">PRINT INVOICE</th>
					<th scope="col">FEEDBACK</th>
				</tr>
					 </thead>
				<tbody>
					<?php
					


// Loop through the query results and display them in the table
$i = ($page_number - 1) * $records_per_page + 1;

if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    ?>
    <tr>
      <td><?php echo $i++ ?></td>
      <td># <?php echo $row['ordersID'] ?></td>
      <td><?php echo $row['orderDate'] ?></td>
      <td><?php echo $row['status'] ?></td>
	  <td>
		  <a href="invoice.php?id=<?php echo $row['ordersID'] ?>" class="link-dark" style="text-decoration: none;"><i class="fa fa-download"></i>&nbsp;Details</a>
	  </td>
	  <td>
		  <a href="rating.php?id=<?php echo $row['ordersID'] ?>" class="link-dark" style="text-decoration: none;"><i class="fa fa-hand-o-right"></i>&nbsp;Rating</a>
	  </td>
    </tr>
    <?php
  }
} else {
  echo "No results found.";
}

// Display pagination links
?>
<div class="d-flex justify-content-center">
  <nav aria-label="Page navigation example">
    <ul class="pagination">
      <?php if ($page_number > 1) { ?>
        <li class="page-item">
          <li class="page-item <?php echo $page_number <= 1 ? 'disabled' : '' ?>">
  <a class="page-link" href="<?php echo $_SERVER['PHP_SELF'] . '?page=' . ($page_number - 1) . '&package_name=' . $package_name . '&appointment_date=' . $appointment_date ?>">Previous</a>
</li>
        </li>
      <?php } ?>
      <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
        <li class="page-item <?php echo ($page_number == $i) ? 'active' : ''; ?>">
          <a class="page-link" href="<?php echo $_SERVER['PHP_SELF'] . '?page=' . $i; ?>"><?php echo $i; ?></a>
</li>
<?php } ?>
<?php if ($page_number < $total_pages) { ?>
<li class="page-item <?php echo $page_number >= $total_pages ? 'disabled' : '' ?>">
  <a class="page-link" href="<?php echo $_SERVER['PHP_SELF'] . '?page=' . ($page_number + 1) . '&package_name=' . $package_name . '&appointment_date=' . $appointment_date ?>">Next</a>
</li>
<?php } ?>
</ul>

  </nav>
</div>
				</tbody>
			</table>
		</div>
	
	<!--bootsrap-->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
					
	</body>
</html>



	