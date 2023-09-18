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

// Set the default year to the current year
$currentYear = date('Y');

// Check if a year is submitted
if (isset($_POST['submit'])) {
  $selectedYear = $_POST['selectedYear'];
} else {
  $selectedYear = date('');
}

// Retrieve the total sales of each month for the selected year
$sql = "SELECT MONTH(pm.paymentDate) AS month, SUM(p.p_unitPrice * ad.p_quantity) AS totalSale
        FROM product_detail ad
        INNER JOIN product p ON ad.productID = p.productID
        INNER JOIN orders o ON ad.ordersID = o.ordersID
        INNER JOIN payment pm ON ad.ordersID = pm.ordersID
        WHERE YEAR(pm.paymentDate) = '$selectedYear'
        GROUP BY MONTH(pm.paymentDate)
        ORDER BY MONTH(pm.paymentDate)";
$result = mysqli_query($conn, $sql);

// Prepare arrays to store the month names and total sales
$monthNames = [];
$totalSales = [];

// Initialize the arrays with default values
for ($month = 1; $month <= 12; $month++) {
  $monthNames[] = date('F', mktime(0, 0, 0, $month, 1));
  $totalSales[] = 0;
}

// Fetch the results and update the total sales array
while ($row = mysqli_fetch_assoc($result)) {
  $month = $row['month'];
  $totalSale = $row['totalSale'];
  $totalSales[$month - 1] = $totalSale;
}

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

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
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
          <select class="form-select" name="selectedYear" required>
            <?php for ($year = 2022; $year <= $currentYear; $year++) {
              $selected = $year == $selectedYear ? 'selected' : '';
              echo "<option value=\"$year\" $selected>$year</option>";
            } ?>
          </select>
        </div>
      </div>
      <div class="col-md-2">
        <button type="submit" name="submit" class="btn btn-primary">Search</button>
      </div>
    </div>
  </form>
</div>

<div class="container" style="margin-top: 30px;max-height: 80%">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <canvas id="salesChart"></canvas>
    </div>
  </div>
</div>

<script>
// Retrieve the total sales and month names from the PHP variables
var totalSales = <?php echo json_encode($totalSales); ?>;
var monthNames = <?php echo json_encode($monthNames); ?>;
var selectedYear = <?php echo $selectedYear; ?>;

// Create the chart
var ctx = document.getElementById('salesChart').getContext('2d');
new Chart(ctx, {
  type: 'bar',
  data: {
    labels: monthNames,
    datasets: [{
      label: 'Total Sales',
      data: totalSales,
      backgroundColor: 'rgba(75, 192, 192, 0.2)',
      borderColor: 'rgba(75, 192, 192, 1)',
      borderWidth: 1
    }]
  },
  options: {
    scales: {
      y: {
        beginAtZero: true,
        ticks: {
          stepSize: 1000
        },
        title: {
          display: true,
          text: 'Sales (RM)',
          font: {
            weight: 'bold'
          }
        }
      },
      x: {
        title: {
          display: true,
          text: 'Month',
          font: {
            weight: 'bold'
          }
        }
      }
    },
    plugins: {
      title: {
        display: true,
        text: 'Yearly Sales in ' + selectedYear,
        font: {
          weight: 'bold'
        }
      },
      legend: {
        display: true,
        position: 'bottom',
        labels: {
          boxWidth: 12
        }
      }
    }
  }
});
</script>
<div class="print" style="margin-top: 20px; text-align: center;"> 
<button type="button" >
  <a href="javascript:window.print()" class="btn btn-light border shadow-none" style="color: black;">
    <i class="fa fa-print"></i> Print
  </a>
</button>
</div>
</body>
</html>
