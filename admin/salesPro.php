<?php
session_start();
include('../connection/connection.php');

if (isset($_SESSION["adminID"])) {
  $adminID = $_SESSION["adminID"];
	
	if((time()-$_SESSION['Active_Time'])>30000)
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

// Retrieve the selected date from the form
if (isset($_POST['submit'])) {
  $selectedDate = $_POST['selectedDate'];
} else {
  // Default to the NULL if no date is selected
  $selectedDate = date('');
}

// Retrieve total sales for package services
$sqlProductSales = "SELECT p.productName, SUM(ad.p_quantity) AS totalQuantity, SUM(p.p_unitPrice * ad.p_quantity) AS totalSale
                    FROM product_detail ad
                    INNER JOIN product p ON ad.productID = p.productID
                    INNER JOIN payment pm ON ad.ordersID = pm.ordersID
                    WHERE pm.paymentDate = '$selectedDate'
                    GROUP BY p.productName";
$resultProductSales = mysqli_query($conn, $sqlProductSales);

// Retrieve the total amount of the daily sale
$sqlTotalSales = "SELECT SUM(p.p_unitPrice * ad.p_quantity) AS totalSales
                  FROM product_detail ad
                  INNER JOIN product p ON ad.productID = p.productID
                  INNER JOIN payment pm ON ad.ordersID = pm.ordersID
                  WHERE pm.paymentDate = '$selectedDate'";
$resultTotalSales = mysqli_query($conn, $sqlTotalSales);
$rowTotalSales = mysqli_fetch_assoc($resultTotalSales);
$totalSales = $rowTotalSales['totalSales'];

// Check if there are no records for the selected date
$noResults = mysqli_num_rows($resultProductSales) == 0;

//the total of the amount after charge
$sqlamount = "SELECT SUM(subquery.totalAmountAfterCharge) AS totalSum FROM (
  SELECT p.amountAfterCharge AS totalAmountAfterCharge
  FROM payment p
  INNER JOIN orders o ON p.ordersID = o.ordersID
  INNER JOIN product_detail pa ON pa.ordersID = o.ordersID
  WHERE p.paymentDate = '$selectedDate'
  GROUP BY p.paymentID, p.amountAfterCharge
) AS subquery";
$resultAmount = mysqli_query($conn, $sqlamount);
$rowAmount = mysqli_fetch_assoc($resultAmount);
$totalCharge = $rowAmount['totalSum'];
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
  <form method="POST">
    <label for="selectedDate">Select Date:</label>
    <input type="date" id="selectedDate" name="selectedDate" value="<?php echo $selectedDate; ?>">
    <button type="submit" name="submit" class="btn btn-primary btn-sm" style="margin-left: 5px;">Search</button>
  </form>
</div>
<?php if ($noResults): ?>
  <p style="margin-left: 90px;"><br>No results found for the selected date.</p>
<?php else: ?>
  <div class="container" style="margin-top: 30px;">
	  <h3><center>Daily Sales</center></h3>
    <table class="table table-hover text-center table-bordered">
      <thead class="table-dark">
      <tr>
        <th scope="col">Product Name</th>
        <th scope="col">Total Quantity</th>
        <th scope="col">Total Sales</th>
      </tr>
      </thead>
      <tbody>
      <?php
      while ($row = mysqli_fetch_assoc($resultProductSales)) {
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

  <?php
  $resultChart = mysqli_query($conn, $sqlProductSales); // New variable to fetch chart data
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
        label: "Product Sales",
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
            text: "Product Name",
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
          text: "Total Daily Sales  - <?php echo date('F j, Y', strtotime($selectedDate)); ?>"
        }
      }
    }
  });

</script>
<br>
</body>
</html>