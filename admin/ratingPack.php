<?php
session_start();
include('../connection/connection.php');
if(isset($_SESSION["adminID"]))
{
  $id= $_SESSION["adminID"];
  
}
else{
  header('Location: ../indexAd.php');
}
?>
<!doctype html>
<html>
<head>
<link rel="shortcut icon" type="image/png" href="../image/pets.png">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<title>Abby Shop</title>
<style type="text/css">
.chart-container {
  display: flex;
  justify-content: space-between;
  margin-top: 30px;
}

.chart {
  border-radius: 5px;
  background-color: #f2f2f2;
  width: 48%;
  max-width: 900px;
  max-height: 2000px;
  margin-left: 10px;
  margin-right: 10px;
}

</style>
</head>

<body>
	<?php include('headerAdmin.php'); ?>
	<h1 style="margin-top: 100px;"><center>Top 3 Best Sales Package</center></h1>
	<div class="chart-container">
		<div class="chart">
			<canvas id="catChart"></canvas>
		</div>
		<div class="chart">
			<canvas id="dogChart"></canvas>
		</div>
	</div>
	
	<?php 
	$sql="SELECT * FROM package p JOIN appointment_detail d ON p.packageID = d.packageID WHERE animalType ='Cat' GROUP BY p.packageID ORDER BY avgRating  desc limit 3";
	$result = mysqli_query($conn,$sql);
	?>
	
	<script>
var xValues = [];
var yValues = [];
var barColors = ["red","lightgreen","blue","orange","brown","yellow","purple","green","pink","lightblue"];

<?php
  while ($row = mysqli_fetch_assoc($result)) {
    echo "xValues.push('" . $row['packageName'] . "');";
    echo "yValues.push(" . $row['avgRating'] . ");";
  }
?>

new Chart("catChart", {
  type: "bar",
  data: {
    labels: xValues,
    datasets: [{
      label: "Package Ratings",
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
          text: "Rating", 
		  font: {
            weight: 'bold'
          }
        }
      },
      x: {
        title: {
          display: true,
          text: "Package Name" ,
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
        text: "Top 3 Sales Packages for Cats"
      }
    }
  }
});		
	</script>
	
	<?php 
	$sql1="SELECT * FROM package p JOIN appointment_detail d ON p.packageID = d.packageID WHERE animalType ='Dog' GROUP BY p.packageID ORDER BY avgRating  desc limit 3";
	$result1 = mysqli_query($conn,$sql1);
	?>
	
	<script>
var xValuesDog = [];
var yValuesDog = [];
var barColorsDog = ["red","lightgreen","blue","orange","brown","yellow","purple","green","pink","lightblue"];

<?php
  while ($row = mysqli_fetch_assoc($result1)) {
    echo "xValuesDog.push('" . $row['packageName'] . "');";
    echo "yValuesDog.push(" . $row['avgRating'] . ");";
  }
?>

new Chart("dogChart", {
  type: "bar",
  data: {
    labels: xValuesDog,
    datasets: [{
      label: "Package Ratings",
      backgroundColor: barColorsDog,
      data: yValuesDog
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
          text: "Rating", 
		  font: {
            weight: 'bold' 
          }
        }
      },
      x: {
        title: {
          display: true,
          text: "Package Name" ,
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
        text: "Top 3 Sales Packages for Dogs"
      }
    }
  }
});		
	</script>
</body>
</html>
