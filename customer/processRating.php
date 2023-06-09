<?php
session_start();
include('../connection/connection.php');

if (isset($_SESSION["customerID"])) {
  $id = $_SESSION["customerID"];
} else {
  header('Location: ../index.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Retrieve the submitted values
  $scores = $_POST['score'];
  $descriptions = $_POST['description'];
  $packageIDs = $_POST['packageID'];
  $ordersIDs = $_POST['ordersID'];

  // Iterate through the submitted data
  for ($i = 0; $i < count($packageIDs); $i++) {
    $score = $scores[$i];
    $description = $descriptions[$packageIDs[$i]];
    $packageID = $packageIDs[$i];
    $ordersID = $ordersIDs[$i];

    $sql = "INSERT INTO rating (score, r_remark, ordersID, packageID) VALUES ('$score', '$description', '$ordersID', '$packageID')";
    
    // Execute the SQL query
    $result = mysqli_query($conn, $sql);
    
    if ($result) {
      // Call the update_avg_rate procedure
      $procedureCall = "CALL update_avg_rate('$packageID')";
      $result = mysqli_multi_query($conn, $procedureCall);
	  
	  $sqlRa =  "UPDATE appointment_detail SET feedback = 'Done' WHERE ordersID = '$ordersID'";
      $resultRa = mysqli_query($conn, $sqlRa);
    }
  }

  if ($result) {
    echo "<script>alert('Rating submitted successfully!');</script>";
    echo "<meta http-equiv='refresh' content='0; url=dog_grooming.php'>";
  } else {
    echo "<script>alert('Failed to submit rating!');</script>";
    echo "<meta http-equiv='refresh' content='0; url=rating.php?id=$ordersID'>";
  }
}

// Close the database connection
mysqli_close($conn);
?>
