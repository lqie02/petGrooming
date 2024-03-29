<?php
include("../connection/connection.php");
session_start();
if(isset($_SESSION["customerID"]))
{
  $id= $_SESSION["customerID"];
	
	if((time()-$_SESSION['Active_Time'])>300)
	{
		header('Location:../index.php');
	}
	else
	{
		$_SESSION['Active_Time'] = time();
	}
}
else{
  header('Location: ../index.php');
}

$sql = "SELECT * FROM package WHERE animalType = 'Dog'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="shortcut icon" type="image/png" href="../image/pets.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
  <link rel="stylesheet" type="text/css" href="../css/dashboard.css">
  <title>Abby Shop</title>
  <style>
    .rating {
      display: flex;
      align-items: center;
    }

  .star-gold {
    color: gold;
 bo  .star-gold {
    color: gold;
 border: 1px solid #ccc; }
  </style>
</head>

<body>
  <?php include('headerCust.php');?>

  <p style="margin-top: 120px;"><center><b style="font-size: 25px;">DOG GROOMING</b></center></p>

  <main>
    <?php 
    $counter = 0; 

    while($row = mysqli_fetch_assoc($result)) {
      $counter++; 

      echo "<form method='post' action='addCart.php' onsubmit='return validateForm($counter)'>"; 
  ?>
      <div class="card"> 
        <div class="image">
          <?php echo '<img src="data:image/jpeg;base64,'.base64_encode($row['p_image']).'" />'; ?>
        </div>
        <div class="caption">
          <!-- Display average rating -->
          <div class="rating">
            <?php
              $averageRating = $row['avgRating'];
              $whole = floor($averageRating); // Extract the whole number part
              $fraction = $averageRating - $whole; // Extract the fractional part

              // Display whole star icons
              for ($i = 1; $i <= $whole; $i++) {
                echo "<span class='star'><i class='fas fa-star star-gold'></i></span>";
              }

              // Display half star icon if the fractional part is greater than 0
              if ($fraction > 0) {
                echo "<span class='star'><i class='fas fa-star-half-alt star-gold'></i></span>";
              }

              // Calculate the remaining empty stars
              $remainingStars = 5 - $whole - ceil($fraction);

              // Display empty star icons
              for ($i = 1; $i <= $remainingStars; $i++) {
                echo "<span class='star'><i class='far fa-star star-gold'></i></span>";
              }
            ?><span style="margin-left: 5px; font-size:  10px">(<?php echo $row['avgRating'] ?>)</span>
          </div>
          <p class="package_name"><b><?php echo $row["packageName"] ?></b></p>
          <p class="price"><b>Price : RM <?php echo $row["unitPrice"] ?></b></p>
          <p class="price"><b>Description :</b></p>
          <p class="price"><?php echo $row["description"] ?></p>

          <input type='hidden' name='packageID' value='<?php echo $row["packageID"] ?>'/>
          <input type='hidden' name='unitPrice' value='<?php echo $row["unitPrice"] ?>'/>
          <input type='hidden' name='packageName' value='<?php echo $row["packageName"] ?>'/> 
          <p class="price">Quantity:
            <input type="number" name="quantity" id="quantity_<?php echo $row["packageID"]; ?>" value="0" min="1" class="form-control">
          </p>
<p class="price" for="appointmentDate">
  Appointment Date:
  <?php
	date_default_timezone_set('Asia/Kuala_Lumpur');
    $oneMonthFromNow = date('Y-m-d\TH:i', strtotime('+1 month'));
	$currentDateTime = date('Y-m-d\TH:i');
  ?>
  <input type="datetime-local" name="appointmentDate" id="appointmentDate_<?php echo $counter; ?>" class="form-control" max="<?php echo $oneMonthFromNow; ?>" min="<?php echo $currentDateTime; ?>">
  <span id="dateError_<?php echo $counter; ?>" style="color: red; display: none;">Please enter a valid appointment date.</span>
</p>
          <button class="add" type="submit" name="add_to_cart">Add to Cart</button>
        </div>
      </div>
    </form>
    <?php } ?>
  </main><br>

<script>
  function validateForm(counter) {
    var appointmentDateInput = document.getElementById("appointmentDate_" + counter);
    var appointmentDateValue = appointmentDateInput.value.trim(); // Trim any leading/trailing spaces
    
    if (appointmentDateValue === "") {
      alert('Please fill in the appointment date.');
      return false;
    }

    var appointmentDate = new Date(appointmentDateValue); 
    var currentDate = new Date();

    if (isNaN(appointmentDate.getTime())) {
      alert('Please enter a valid appointment date.');
      return false;
    }
    
    if (appointmentDate <= currentDate) {
      alert('Please select a future appointment date.');
      return false;  
    }
    
    return true;
  }
</script>

</body>
</html>
