<?php
include("../connection/connection.php");
 session_start();
  if (isset($_SESSION["customerID"])) {
    $customerID = $_SESSION["customerID"];
  } else {
    header("Location: ../index.php");
    exit();
  }

if (isset($_POST['checkout'])){

  // calculate package IDs and total prices from cart
  $amount_after_charging = $_POST['amountAfterCharging'];
  $serviceCharge = $_POST['serviceCharge'];
  $packageID = array();
  $totalPrice = array();
  $appointmentDate = array();
  foreach ($_SESSION["cart"] as $item) {
    $packageID[] = $item["packageID"];
    $totalPrice[] = $item["quantity"] * $item["unitPrice"];
    $appointmentDate[] = $item["appointmentDate"];
  }
  

  $totalAmount = 0;
  $totalPrice = 0;
  foreach ($_SESSION["cart"] as $item) {
    $subtotal = $item["quantity"] * $item["unitPrice"];
    $totalPrice += $subtotal;
  }

  // calculate total amount
  foreach ($_SESSION["cart"] as $item) {
    $totalAmount += $item["quantity"] * $item["unitPrice"];
  }


  
  // insert appointment into database
  $stmt = $conn->prepare("INSERT INTO orders (customerID, orderDate, totalAmount) VALUES (?, ?, ?)");
  $orderDate = date('Y-m-d H:i:s');
  $stmt->bind_param("iss", $customerID, $orderDate, $totalAmount);

  if ($stmt->execute()) {
    $ordersID = $stmt->insert_id;

    // insert appointment details into database
    $stmt = $conn->prepare("INSERT INTO appointment_detail (ordersID, packageID, quantity, appointmentDate, totalPrice,status) VALUES (?, ?, ?, ?, ?,'Pending')");

    foreach ($_SESSION["cart"] as $item) 
	{
    $packageID = $item["packageID"];
    $quantity = $item["quantity"];
    $appointmentDate = $item["appointmentDate"];
    $totalPrice = $item["unitPrice"] * $quantity;
	$stmt->bind_param("iiiss", $ordersID, $packageID, $quantity, $appointmentDate, $totalPrice);
		
		

    if (!$stmt->execute()) 
	{
        echo "Error inserting appointment detail: " . $stmt->error;
        exit();
    }
		
	}
	  
    
    // clear shopping cart

	unset($_SESSION['cart']);
    $amount_after_charging = $_POST['amountAfterCharging'];
	$seviceCharge = $_POST['serviceCharge'];
    $success_message = "Appointment made successfully. Proceed to payment.";
    $redirect_url = "payment.php?amount=" . urlencode($amount_after_charging) . "&orderid=" . urlencode($ordersID) . "&charge=" . urlencode($serviceCharge);
    echo "<script>alert('$success_message'); window.location.href='$redirect_url';</script>";
    exit();



    exit();
  } else {
    echo "Error inserting order: " . $stmt->error;
  }
}

?>
