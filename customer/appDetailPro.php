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
  $productID = array();
  $totalPrice = array();
  foreach ($_SESSION["cart1"] as $item) {
    $packageID[] = $item["productID"];
    $totalPrice[] = $item["quantity"] * $item["unitPrice"];
  }
  

  $totalAmount = 0;
  $totalPrice = 0;
  foreach ($_SESSION["cart1"] as $item) {
    $subtotal = $item["quantity"] * $item["unitPrice"];
    $totalPrice += $subtotal;
  }

  // calculate total amount
  foreach ($_SESSION["cart1"] as $item) {
    $totalAmount += $item["quantity"] * $item["unitPrice"];
  }


  
  // insert order into database
  $stmt = $conn->prepare("INSERT INTO orders (customerID, orderDate, totalAmount) VALUES (?, ?, ?)");
  $orderDate = date('Y-m-d H:i:s');
  $stmt->bind_param("iss", $customerID, $orderDate, $totalAmount);

  if ($stmt->execute()) {
    $ordersID = $stmt->insert_id;

    // insert appointment details into database
    $stmt = $conn->prepare("INSERT INTO product_detail (ordersID, productID, p_quantity, p_totalPrice,p_status) VALUES (?, ?, ?, ?,'Pending')");

    foreach ($_SESSION["cart1"] as $item) 
	{
    $productID = $item["productID"];
    $quantity = $item["quantity"];
    $totalPrice = $item["unitPrice"] * $quantity;
	$stmt->bind_param("iiis", $ordersID, $productID, $quantity, $totalPrice);
		
		

    if (!$stmt->execute()) 
	{
        echo "Error inserting product detail: " . $stmt->error;
        exit();
    }
	
	// Update product table to deduct stock quantity
    
	}
	  
    
// clear shopping cart
	unset($_SESSION['cart1']);
    $amount_after_charging = $_POST['amountAfterCharging'];
	$seviceCharge = $_POST['serviceCharge'];
    $success_message = "Orders made successfully. Proceed to payment.";
    $redirect_url = "paymentPro.php?amount=" . urlencode($amount_after_charging) . "&orderid=" . urlencode($ordersID) . "&charge=" . urlencode($serviceCharge);
    echo "<script>alert('$success_message'); window.location.href='$redirect_url';</script>";
    exit();



    exit();
  } else {
    echo "Error inserting order: " . $stmt->error;
  }
}

?>
