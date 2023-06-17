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
$id = $_GET['id'];
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="shortcut icon" type="image/png" href="../image/pets.png">
<link rel="stylesheet" href="https://fonts.googleapls.com/css2?family=PT+Sans:wght@400:700&display=swap" >
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="../css/rating.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<title>Abby Shop</title>
</head>

<body>
	<?php include('headerCart.php'); ?>
	<h1 style="margin-top: 10px;"><center>Feedback</center></h1>
	<p><center>Are you satisfied with our service? Please provide a rating and comment. </center></p>
	
	<table class="content-table" border="0" cellspacing="30" width="50%" align="center">
	<form action='processRating.php' method='post' onsubmit='return checkRating()'>
	<tbody>
	<?php
		$sql = "SELECT * FROM appointment_detail a, package p WHERE a.packageID = p.packageID AND a.ordersID = '$id'";
		$result = mysqli_query($conn,$sql);
				
		while($row = mysqli_fetch_assoc($result))
		{ ?>
			<tr>
				<th>
					<?php echo '<img src="data:image/jpeg;base64,'.base64_encode($row['p_image']).'" />'; ?>
				</th>
				<td>
					<b style="font-size: 18px;"><?php echo $row['packageName'] ?></b>
					<br>
					<input type='hidden' name='score[]' id='score<?php echo $row['packageID']; ?>'>
					<span class='fa fa-star' onmouseover='setRating(1,<?php echo $row['packageID']; ?>)' data-package-id='<?php echo $row['packageID']; ?>'></span>
					<span class='fa fa-star' onmouseover='setRating(2,<?php echo $row['packageID']; ?>)' data-package-id='<?php echo $row['packageID']; ?>'></span>
					<span class='fa fa-star' onmouseover='setRating(3,<?php echo $row['packageID']; ?>)' data-package-id='<?php echo $row['packageID']; ?>'></span>
					<span class='fa fa-star' onmouseover='setRating(4,<?php echo $row['packageID']; ?>)' data-package-id='<?php echo $row['packageID']; ?>'></span>
					<span class='fa fa-star' onmouseover='setRating(5,<?php echo $row['packageID']; ?>)' data-package-id='<?php echo $row['packageID']; ?>'></span><br>
					<p>Do you have any experience you would like to share?</p>
					<textarea id="description<?php echo $row['packageID']; ?>" rows="5" cols="45" name="description[<?php echo $row['packageID']; ?>]"></textarea>

					<input type="hidden" name="packageID[]" value="<?php echo $row['packageID']; ?>">
					<input type="hidden" name="ordersID[]" value="<?php echo $row['ordersID']; ?>">

				</td>
			</tr>
	<?php 
		} ?>
		
			<th colspan="2" style="text-align: center;">
  			<button type="submit" class="btn btn-outline-secondary">Submit Rating</button>
			</th>


		
	</tbody>
	</form>
	</table>
	
<script>
  let ratingSelected = false;

  function setRating(score, packageID) {
    ratingSelected = true;

    // Reset all stars to default state
    var stars = document.querySelectorAll('.fa-star[data-package-id="' + packageID + '"]');
    for (var i = 0; i < stars.length; i++) {
      stars[i].classList.remove("checked");
    }

    // Set the selected stars to checked state
    for (var i = 0; i < score; i++) {
      stars[i].classList.add("checked");
    }

    // Set the rating value in the hidden input field
    document.getElementById("score" + packageID).value = score;
  }

  function checkRating() {
    if (!ratingSelected) {
      alert("Please select a rating");
      return false; // prevent form submission
    }

    return true; // allow form submission
  }	
	
</script>
</body>
</html>
