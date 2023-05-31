<?php
  session_start();
  $visitor =  $_SESSION['visitorID'];
  $id = $_GET['id'];
  include "../connection/connection.php";


?>
<!doctype html>
<html>
<head>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="shortcut icon" type="png" href="../image/fork.png">
<link rel="stylesheet" href="https://fonts.googleapls.com/css2?family=PT+Sans:wght@400:700&display=swap" >
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<title>Plates of Joys</title>
	<style>
		h1 .cn
		{
			font-family: KaiTi;
		}

	</style>
</head>

<body>
	
		<!-- Navbar (sit on top) -->
<div class="w3-top">
  <div class="w3-bar w3-white w3-wide w3-padding w3-card">
    <a href="../home.php" class="w3-bar-item w3-button"><b>PLATES</b> of JOYS</a>
    <!-- Float links to the right. Hide them on small screens -->
    <div class="w3-right w3-hide-small">
      <a href="chinese.php?id=5003" class="w3-bar-item w3-button">Content</a>
      <a href="#about" class="w3-bar-item w3-button">About</a>
      <a href="logout.php" class="w3-bar-item w3-button">Logout</a>
    </div>
  </div>
</div>
	
	<h1><center>Result  <span class="cn">(成绩)</span></center></h1>
	
	<div class="container">
			<table class="table table-hover text-center">
				 <thead class="table-dark">
					<tr>
						<th scope="col">NO.</th>
						<th scope="col">ASSESSMENT NAME</th>
						<th scope="col">LEVEL</th>
						<th scope="col">MARKS</th>
						<th scope="col">ASSESSMENT DATE</th>			
					</tr>
					 </thead>
				<tbody>
					
	
	<?php
	$test=mysqli_query($conn,"SELECT * FROM assessmenttaken a, asssessment s WHERE a.ASSID = s.ASSID AND VISITORID = '$id'");
		
	$i=1;
		   
		if(mysqli_num_rows($test)>0){
			while ($row=mysqli_fetch_assoc($test)){
				?><tr>
					<td><?php echo $i++ ?></td>
					<td><?php echo $row['ASSNAME'] ?></td>
					<td><?php echo $row['LEVEL'] ?></td>
					<td><?php echo $row['MARKS'] ?></td>
					<td><?php echo $row['ASSDATE'] ?></td>
					</tr>
					<?php }
		}?>
				</tbody>
			</table>
		</div>
	
</body>
</html>