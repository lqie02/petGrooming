<?php
include("../connection/connection.php");
session_start();
if(isset($_SESSION["customerID"]))
{
	$id= $_SESSION["customerID"];
	
}
else{
	header('Location: ../index.php');
}
if(!isset($_SESSION['cart1'])){
    $_SESSION['cart1'] = array();
}
?>


<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" type="image/png" href="../image/pets.png">
	<!--Bootstrap-->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<title>Abby Shop</title>
	
	<?php
		if (isset($_POST['add_to_cart'])) 
		{
    		$session_array_id = array_column($_SESSION['cart1'], "productID");

			if (!in_array($_POST['productID'], $session_array_id)) 
			{
        		$session_array = array(
					"productID" => $_POST['productID'],
					"productName" => $_POST['productName'],
					"unitPrice" => $_POST['unitPrice'],
            		"quantity" => $_POST['quantity'],
        		);
					$_SESSION['cart1'][] = $session_array;
    		}
    		else 
			{
				// If the package is already in the cart, update the quantity 
        		foreach ($_SESSION['cart1'] as &$item) 
				{
            		if ($item['productID'] == $_POST['productID']) 
					{
						$item['quantity'] += $_POST['quantity'];
                	break;
            		}
        		}
    		}
		}
	?>
</head>

<body>
	<?php include('headerCart.php');?>
	<div class="container">
  <h2 class = "text-center" style="margin-top: 150px;"> Product</h2>
  <?php

  $output = "";

  $output .= "
<table class = 'table table-bordered text-center'>
<thead class='table-dark'>
<tr>
<th scope='col'>No.</th>
<th scope='col'>Product Name</th>
<th scope='col'>Unit Price</th>
<th scope='col'>Quantity</th>
<th scope='col'>Total price</th>
<th scope='col'>Action</th>
</tr>
</thead>
  ";

if(!empty($_SESSION['cart1'])){
	$counter = 1;
  foreach($_SESSION['cart1'] as $key => $value){

    $output .="
    <tr>
	<td>".$counter."</td>
    <td>".$value['productName']."</td>
    <td>RM ".$value['unitPrice']."</td>
<td>
  <form method='post' action=''>
    <input type='number' name='quantity' value='" . $value['quantity'] . "' min='1' max='100'>
    <input type='hidden' name='productID' value='" . $value['productID'] . "'>
    <button type='submit' name='update_quantity' class='btn btn-outline-secondary btn-sm' style='margin-left:3px; margin-top:-2px;'>
      <i class='fa fa-refresh 'aria-hidden='true'></i>
    </button>
  </form>
</td>

    <td>RM ".number_format($value['unitPrice'] * $value['quantity'],2)."
	</td>

    <td>
<a href='addCartPro.php?action=remove&id=".$value['productID']."'>
<button class='btn btn-outline-danger btn-sm'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></button>
</a>
</td>
";
$total_amount = 0;
foreach ($_SESSION['cart1'] as $value) {
    $total_amount += $value['quantity'] * $value['unitPrice'];
}
	  $counter++;
}
$serviceCharge = $total_amount * 0.05;
$amount_after_charging = $total_amount + $serviceCharge;
$output .= "
    <tr>
        <td colspan='3'></td>
        <td><b>Total Amount : </b></td>
        <td>RM " . number_format($total_amount,2) . "</td>
        <td>
        </td>
    </tr>
	<tr>
        <td colspan='3'></td>
        <td><b>Service Charge (5%): </b></td>
        <td>RM " . number_format($serviceCharge,2) . "</td>
        <td>
        </td>
    </tr>
    <tr>
        <td colspan='3'></td>
        <td><b>Amount after Charging: </b></td>
        <td>RM " . number_format($amount_after_charging,2) . "</td>
        <td>
        </td>
    </tr>
</table>

<form action='appDetailPro.php' method='post' style='float: right; '>";

	foreach ($_SESSION['cart1'] as $key => $value) {
    $output .= "
		<input type='hidden' name='productID[$key]' value='{$value['productID']}'>
         <input type='hidden' name='totalPrice[$key]' value='" . number_format($value['unitPrice'] * $value['quantity'], 2) . "'>
    ";
}
	
$output .= "
	<input type='hidden' name='amountAfterCharging' value='" . number_format($amount_after_charging, 2) . "'>
	<input type='hidden' name='serviceCharge' value='" . number_format($serviceCharge, 2) . "'>
    <button type='submit' name='checkout' class='btn btn-outline-secondary' onclick='return confirmCheckout()'>Checkout</button>
	
</form>
";




  }
if (isset($_POST['update_quantity'])) {
  if (is_array($_SESSION['cart1'])) {
    foreach ($_SESSION['cart1'] as &$item) {
      if ($item['productID'] == $_POST['productID']) {
        $item['quantity'] = $_POST['quantity'];
        break;
      }
    }
  }
  // send output and turn off output buffering
  header('Location: ' . $_SERVER['PHP_SELF']);
}
	
		
if(isset($_GET['action']) && $_GET['action']=="remove" && isset($_GET['id'])){
  foreach($_SESSION['cart1'] as $key => $value){
    if($value['productID']==$_GET['id']){
      unset($_SESSION['cart1'][$key]);
    }
  }
  header('Location: ' . $_SERVER['PHP_SELF']);
  exit();
}

// Output the cart items
echo $output;
		
?>
<script>
function confirmCheckout() {
  if (confirm('Are you sure you want to confirm the ORDER and proceed to payment?')) {
    window.location.href = 'appDetailPro.php';
    return true;
  } else {
    return false;
  }
}
	
function confirmLogout() {
  <?php if (!empty($_SESSION['cart1'])) { ?>
    if (confirm('Your cart is not empty. Are you sure you want to logout?')) {
      window.location.href = '../logout.php';
      return true;
    } else {
      return false;
    }
  <?php } else { ?>
    return true;
  <?php } ?>
}
</script>
</body>
</html>