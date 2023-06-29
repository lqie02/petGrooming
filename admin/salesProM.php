<?php
session_start();
include('../connection/connection.php');

if (isset($_SESSION["adminID"])) {
  $adminID = $_SESSION["adminID"];
	
	if((time()-$_SESSION['Active_Time'])>300)
	{
		header('Location:../indexAd.php');
	}
	else
	{
		$_SESSION['Active_Time'] = time();
	}
} else {
  header('Location: ../indexAd.php');
}

// Check if a month is submitted
if (isset($_POST['submit'])) {
  $selectedMonth = $_POST['selectedMonth'];
  $selectedYear = $_POST['selectedYear'];
} else {
  // Default to the NULL if no selection is made
  $selectedMonth = date('');
  $selectedYear = date('');
}

// Array of month names
$monthNames = array(
  'January', 'February', 'March', 'April', 'May', 'June',
  'July', 'August', 'September', 'October', 'November', 'December'
);

// Retrieve the top 5 packages with the highest sales for the selected month
$sql = "SELECT p.productName, SUM(ad.p_quantity) AS totalQuantity, SUM(p.p_unitPrice * ad.p_quantity) AS totalSale
        FROM product_detail ad
        INNER JOIN product p ON ad.productID = p.productID
        INNER JOIN payment pm ON ad.ordersID = pm.ordersID
        INNER JOIN orders o ON ad.ordersID = o.ordersID
        WHERE MONTH(pm.paymentDate) = '$selectedMonth' AND YEAR(pm.paymentDate) = '$selectedYear'
        GROUP BY p.productID
        ORDER BY totalSale DESC
        LIMIT 5";
$result = mysqli_query($conn, $sql);

//calculate the total amount of sales for the top 5 package
$sqlTotalSales = "SELECT SUM(subquery.totalSale) AS totalSalesOfTopProduct FROM (
  				SELECT p.productName, SUM(ad.p_quantity) AS totalQuantity, SUM(p.p_unitPrice * ad.p_quantity) AS totalSale
  				FROM product_detail ad
  				INNER JOIN product p ON ad.productID = p.productID
  				INNER JOIN payment pm ON ad.ordersID = pm.ordersID
  				INNER JOIN orders o ON ad.ordersID = o.ordersID
  				WHERE MONTH(pm.paymentDate) = '$selectedMonth' AND YEAR(pm.paymentDate) = '$selectedYear'
  				GROUP BY p.productID
  				ORDER BY totalSale DESC
				LIMIT 5
				) AS subquery";
$resultTotalSales = mysqli_query($conn,$sqlTotalSales);
$rowTotalSales = mysqli_fetch_assoc($resultTotalSales);
$totalSales = $rowTotalSales['totalSalesOfTopProduct'];

// Check if there are no records for the selected date
$noResults = mysqli_num_rows($result) == 0;

//
$sqlAfterCharge = "SELECT SUM(subquery.totalAmountAfterCharge) AS totalSum FROM (
  				SELECT p.amountAfterCharge AS totalAmountAfterCharge
  				FROM payment p
  				INNER JOIN orders o ON p.ordersID = o.ordersID
  				INNER JOIN product_detail pa ON pa.ordersID = o.ordersID
  				WHERE MONTH(p.paymentDate) = '$selectedMonth' AND YEAR(p.paymentDate) = '$selectedYear'
  				GROUP BY p.paymentID, p.amountAfterCharge ) AS subquery";
$resultAfterCharge = mysqli_query($conn,$sqlAfterCharge);
$rowAfterCharge = mysqli_fetch_assoc($resultAfterCharge);
$totalCharge = $rowAfterCharge['totalSum'];
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="shortcut icon" type="image/png" href="../image/pets.png">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!--Bootstrap-->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<!--font Awesome-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<title>Sales Report</title>
</head>

<body>

<?php include('headerAdmin.php'); ?> <br><br><br><br>

<h2>
  <center>Sales Report Product</center>
</h2><br>
	
<div style="margin-left: 100px;">
<a href="salesPro.php"><button type="button" class="btn btn-secondary">&nbsp;Daily Sales&nbsp;</button></a>
<a href="salesProM.php"><button type="button" class="btn btn-secondary" style="margin-left: 8px">&nbsp;Monthly Sales&nbsp;</button></a>
<a href="salesProY.php"><button type="button" class="btn btn-secondary" style="margin-left: 8px">&nbsp;Yearly Sales&nbsp;</button></a>
</div>

 <div class="row mb-3" style="margin-left: 90px;margin-top: 30px">
  <form method="post" action="">
    <div class="row justify-content-center">
      <div class="col-md-4">
        <div class="input-group mb-3">
          <select class="form-select" name="selectedMonth" required>
            <option value="" disabled selected>Select Month</option>
            <option value="01">January</option>
            <option value="02">February</option>
            <option value="03">March</option>
            <option value="04">April</option>
            <option value="05">May</option>
            <option value="06">June</option>
            <option value="07">July</option>
            <option value="08">August</option>
            <option value="09">September</option>
            <option value="10">October</option>
            <option value="11">November</option>
            <option value="12">December</option>
          </select>
        </div>
      </div>
      <div class="col-md-4">
        <div class="input-group mb-3">
          <select class="form-select" name="selectedYear" required>
            <option value="" disabled selected>Select Year</option>
            <?php
            $currentYear = date('Y');
            for ($year = $currentYear; $year >= 2022; $year--) {
              echo "<option value='$year'>$year</option>";
            }
            ?>
          </select>
        </div>
      </div>
      <div class="col-md-4">
        <div class="input-group mb-3">
          <button type="submit" name="submit" class="btn btn-primary">Search</button>
        </div>
      </div>
    </div>
  </form>
	  </div>
<?php if ($noResults): ?>
  <p style="margin-left: 90px;"><br>No results found for the selected date.</p>
<?php else: ?>
  <div class="container" style="margin-top: 30px;">

  <h3><center>Top 5 Monthly Sales Package (<?php echo date('F Y', strtotime($selectedYear . '-' . $selectedMonth . '-01')); ?>)</center></h3>

  <table class="table table-hover text-center table-bordered">
    <thead class="table-dark">
    <tr>
      <th scope="col">Package Name</th>
      <th scope="col">Total Quantity</th>
      <th scope="col">Total Sales</th>
    </tr>
    </thead>
    <tbody>
    <?php
    while ($row = mysqli_fetch_assoc($result)) {
      echo "<tr>";
      echo "<td>" . $row['productName'] . "</td>";
      echo "<td>" . $row['totalQuantity'] . "</td>";
      echo "<td>RM " . $row['totalSale'] . "</td>";
      echo "</tr>";
    }
    ?>
    <tr>
      <td colspan='2'><strong>Total Sales:</strong></td>
      <td><strong>RM <?php echo $totalSales; ?></strong></td>
    </tr>
    <tr>
      <td colspan='2'><strong>Total Sales After Charge:</strong></td>
      <td><strong>RM <?php echo $totalCharge; ?></strong></td>
    </tr>
      <tr>
        <td colspan='2'><strong>Profit Charge:</strong></td>
        <td><strong>RM <?php echo number_format($totalCharge - $totalSales, 2); ?></strong></td>
      </tr>
    </tbody>
  </table>
</div>
<?php endif; ?>
<br>
<canvas id="Chart" style="width: 100%; max-width: 900px; max-height: 500px; margin: 0 auto;background-color: #f2f2f2;"></canvas>

<script>
  var xValues = [];
  var yValues = [];
  var barColors = ["red", "lightgreen", "blue", "orange", "brown", "yellow", "purple", "green", "pink", "lightblue"];
  var selectedYear = <?php echo $selectedYear; ?>;
  var selectedMonth = <?php echo $selectedMonth; ?>;
  var monthNames = <?php echo json_encode($monthNames); ?>;
  
  <?php
  $resultChart = mysqli_query($conn, $sql); // New variable to fetch chart data
  while ($row = mysqli_fetch_assoc($resultChart)) {
    echo "xValues.push('" . $row['productName'] . "');";
    echo "yValues.push(" . $row['totalSale'] . ");";
  }
  ?>

  new Chart("Chart", {
    type: "bar",
    data: {
      labels: xValues,
      datasets: [{
        label: "Total Sales (RM)",
        backgroundColor: barColors,
        data: yValues
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            stepSize: 1
          },
          title: {
            display: true,
            text: "Sales (RM)",
            font: {
              weight: 'bold'
            }
          }
        },
        x: {
          title: {
            display: true,
            text: "Package Name",
            font: {
              weight: 'bold'
            }
          }
        }
      },
      responsive: true,
      plugins: {
        legend: {
          display: false
        },
        title: {
          display: true,
          text: "Top 5 Monthly Sales Package in " + monthNames[selectedMonth - 1] + " " + selectedYear,
        }
      }
    }
  });
</script>
<br>
</body>
</html>
