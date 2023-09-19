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
if(!isset($_SESSION['cart'])){
    $_SESSION['cart'] = array();
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
if (isset($_POST['add_to_cart'])) {
    $session_array_id = array_column($_SESSION['cart'], "packageID");

    if (!in_array($_POST['packageID'], $session_array_id)) {
        $session_array = array(
            "packageID" => $_POST['packageID'],
            "packageName" => $_POST['packageName'],
            "unitPrice" => $_POST['unitPrice'],
            "quantity" => $_POST['quantity'],
            "appointmentDate" => $_POST['appointmentDate'],

        );
        $_SESSION['cart'][] = $session_array;
    }
    else {
        // If the package is already in the cart, update the quantity and appointment date
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['packageID'] == $_POST['packageID']) {
                $item['quantity'] += $_POST['quantity'];
                $item['appointmentDate'] = $_POST['appointmentDate'];
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
  <h2 class = "text-center" style="margin-top: 150px;"> Appointment</h2>
  <?php

  $output = "";

  $output .= "
<table class = 'table table-bordered text-center'>
<thead class='table-dark'>
<tr>
<th scope='col'>No.</th>
<th scope='col'>Package Name</th>
<th scope='col'>Unit Price</th>
<th scope='col'>Quantity</th>
<th scope='col'>Appointment Date</th>
<th scope='col'>Total price</th>
<th>Action</th>
</tr>
</thead>
  ";

if(!empty($_SESSION['cart'])){
	$counter = 1;
  foreach($_SESSION['cart'] as $key => $value){
  date_default_timezone_set('Asia/Kuala_Lumpur');
  $oneMonthFromNow = date('Y-m-d\TH:i', strtotime('+1 month'));
  $currentDateTime = date('Y-m-d\TH:i');
	  
    $output .="
    <tr>
	<td>".$counter."</td>
    <td>".$value['packageName']."</td>
    <td>RM ".$value['unitPrice']."</td>
<td>
  <form method='post' action=''>
    <input type='number' name='quantity' value='" . $value['quantity'] . "' min='1' max='100'>
    <input type='hidden' name='packageID' value='" . $value['packageID'] . "'>
    <button type='submit' name='update_quantity' class='btn btn-outline-secondary btn-sm' style='margin-left:3px; margin-top:-2px;'>
      <i class='fa fa-refresh 'aria-hidden='true'></i>
    </button>
  </form>
</td>
        <td>
          <form method='post' action=''>
            <input type='datetime-local' name='appointmentDate' value='".$value['appointmentDate']."' max='".$oneMonthFromNow."' min='".$currentDateTime."'>
            <input type='hidden' name='packageID' value='".$value['packageID']."'>
            <button type='submit' name='update_appointment_date' class='btn btn-outline-secondary btn-sm' style='margin-left:3px; margin-top:-2px;'>
              <i class='fa fa-refresh' aria-hidden='true'></i>
            </button>
          </form>
        </td>

    <td>RM ".number_format($value['unitPrice'] * $value['quantity'],2)."</td>
    <td>
<a href='addCart.php?action=remove&id=".$value['packageID']."'>
<button class='btn btn-outline-danger btn-sm'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></button>
</a>
</td>
";
$total_amount = 0;
foreach ($_SESSION['cart'] as $value) {
    $total_amount += $value['quantity'] * $value['unitPrice'];
}
	  $counter++;
}
$serviceCharge = $total_amount * 0.1;
$amount_after_charging = $total_amount + $serviceCharge;
$output .= "
    <tr>
        <td colspan='4'></td>
        <td><b>Total Amount : </b></td>
        <td>RM " . number_format($total_amount,2) . "</td>
        <td>
        </td>
    </tr>
	<tr>
        <td colspan='4'></td>
        <td><b>Service Charge (10%): </b></td>
        <td>RM " . number_format($serviceCharge,2) . "</td>
        <td>
        </td>
    </tr>
    <tr>
        <td colspan='4'></td>
        <td><b>Amount after Charging: </b></td>
        <td>RM " . number_format($amount_after_charging,2) . "</td>
        <td>
        </td>
    </tr>
</table>

<form action='appDetails.php' method='post' style='float: right; '>";

	foreach ($_SESSION['cart'] as $key => $value) {
    $output .= "
		<input type='hidden' name='packageID[$key]' value='{$value['packageID']}'>
         <input type='hidden' name='totalPrice[$key]' value='" . number_format($value['unitPrice'] * $value['quantity'], 2) . "'>
		<input type='hidden' name='appointmentDate[$key]' value='" . $value['appointmentDate']. "'>

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
  if (is_array($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as &$item) {
      if ($item['packageID'] == $_POST['packageID']) {
        $item['quantity'] = $_POST['quantity'];
        break;
      }
    }
  }
  // send output and turn off output buffering
  header('Location: ' . $_SERVER['PHP_SELF']);
}
		
if (isset($_POST['update_appointment_date'])) {
  if (is_array($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as &$item) {
      if ($item['packageID'] == $_POST['packageID']) {
        $item['appointmentDate'] = $_POST['appointmentDate'];
        break;
      }
    }
  }
  // send output and turn off output buffering
  header('Location: ' . $_SERVER['PHP_SELF']);
}	
	

		
if(isset($_GET['action']) && $_GET['action']=="remove" && isset($_GET['id'])){
  foreach($_SESSION['cart'] as $key => $value){
    if($value['packageID']==$_GET['id']){
      unset($_SESSION['cart'][$key]);
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
  if (confirm('Are you sure you want to confirm the appointment and proceed to payment?')) {
    window.location.href = 'appDetails.php';
    return true;
  } else {
    return false;
  }
}

function confirmLogout() {
  <?php if (!empty($_SESSION['cart'])) { ?>
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