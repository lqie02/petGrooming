<?php
session_start();
include('../connection/connection.php');

if (isset($_SESSION["customerID"])) {
  $id = $_SESSION["customerID"]; 
} else {
  header('Location: ../index.php');
}

if (isset($_POST['submit'])) {
  // Perform the update query
  $customer_query = mysqli_query($conn, "UPDATE customer SET customerName = '" . $_POST['customerName'] . "', email = '" . $_POST['email'] . "', telephone = '" . $_POST['telephone'] . "', cAddress = '" . $_POST['address'] . "', password = '" . md5($_POST['password']) . "' WHERE customerID ='$id' ");


  // Check if the update was successful
  if ($customer_query) {
    // Trigger the refresh meta tag and display success message
    echo '<meta http-equiv="refresh" content="0;url=profile.php">';
    echo '<script>alert("Update successful");</script>';
  } else {
    // Display error message if the update failed
   die('Update failed: ' . mysqli_error($conn));
  }
}

$customer = mysqli_query($conn, "SELECT * FROM customer WHERE customerID = '" . $id . "'");
$row = mysqli_fetch_assoc($customer);
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" type="image/png" href="../image/pets.png">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" a href="../css/profile.css"> 
<link rel="stylesheet" a href="../css/bootstrapla.css">
<title>Profile</title>  
</head>

<body>
  <?php include('headerCart.php');?>
  <br>
  <div class="page">
    <div class="container">
      <div class="left">
        <div class="inforegister">Customer Details</div>
        <div class="eula">Please click submit after changing any information</div>
      </div>
      <div class="right">
        <div class="form">
          <form action="" method="post">
            <label>Name</label>
            <input type="text" style="font-size: 16px" placeholder="Name" name="customerName" value="<?php echo $row['customerName'] ?>">

            <label>Email</label>
            <input type="text" style="font-size: 16px" placeholder="Email" name="email" value="<?php echo $row['email'] ?>">

            <label>Telephone</label>
            <input type="text" style="font-size: 16px" placeholder="Telephone" name="telephone" value="<?php echo $row['telephone'] ?>">
            
            <label>Address</label>
            <input type="text" style="font-size: 16px" placeholder="Address" name="address" value="<?php echo $row['cAddress'] ?>">

            <label>Password</label>
            <input pattern=".{8,}" type="password" placeholder="Password" name="password" title="8 characters minimum" value="<?php echo $row['password'] ?>">
            <br><br>
            <button class="button button3" name="submit">Submit</button>
          </div>
        </div>
      </div>
    </div>
  </form>
</body>
</html>
