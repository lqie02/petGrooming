<?php
include("connection/connection.php");
session_start();
$msg = '';

if(isset($_POST['btn_login']))
{

  function test_input($data) 
  {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
  }

  $time= time()-30;
  $ip_address = getIpAddr();

    // Getting total count of hits on the basis of IP
  $querys = mysqli_query($conn, "select count(*) as total_count from loginlogs where TryTime > $time and IpAddress='$ip_address'"); 
  $check_login_row=mysqli_fetch_assoc($querys);
  $total_count=$check_login_row['total_count'];
   
   if($total_count == 3)
  {
    $msg="To many failed login attempts. Please login after 30 sec";
  }
	else
	{
		 //Getting Post Values
    $email = test_input($_POST['email']);
    $password = test_input($_POST['password']);
		
		    
   $query =  mysqli_query($conn,"SELECT DISTINCT * FROM customer WHERE LCASE(email) = '" . $email . "' AND password ='". md5($password)."'");
		
		if($query->num_rows > 0){

        
        $row = mysqli_fetch_assoc($query);
      

       
        $_SESSION['customerID'] = $row["customerID"];
        $_SESSION['customerName']   = $row['customerName'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['telephone'] = $row['telephone'];    

        mysqli_query($conn,"DELETE FROM loginlogs WHERE IpAddress = '" . $ip_address . "'");
        echo "<script>alert('Login Success!');</script>";
        echo"<meta http-equiv='refresh' content='0; url=customer/dog_grooming.php'>";
		}
		else
		{
			 $total_count++;
			 $rem_attm = 3 - $total_count;


      		if($rem_attm == 0)
			{

        		$msg="To many failed login attempts. Please login after 30 sec";
      		}
			else
			{
				$msg="Email or Password was wrong.<br/>$rem_attm attempts remaining";
      		}
      		$try_time=time();

			$insert_loginlogs = mysqli_query($conn,"INSERT INTO loginlogs SET IpAddress='".$ip_address."', TryTime ='".$try_time."'  ");
		}
	}

}

// Getting IP Address
  function getIpAddr(){
  if (!empty($_SERVER['HTTP_CLIENT_IP']))
  {
    $ipAddr=$_SERVER['HTTP_CLIENT_IP'];
  }
  elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
  {
    $ipAddr=$_SERVER['HTTP_X_FORWARDED_FOR'];
  }
  else
  {
    $ipAddr=$_SERVER['REMOTE_ADDR'];
  }
  return $ipAddr;
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<link rel="shortcut icon" type="image/png" href="image/pets.png">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="css/index.css"> <!--css-->
	<title>Abby Shop</title>
	
</head>
<body>
	<?php include('headerReg.php');?>
  <div class="container">
    <form action="" method="POST" class="login-email">
      <p align="center" class="login-text" style="font-size: 2rem; font-weight: 800;">Login Customer</p>
      <br>
        <p align="justify">Please login to your account : </p><br>

        <div class="input-group">
          <input type="email" name="email" placeholder="Email address" autofocus required/>
        </div>

        <div class="input-group">
          <input type="password" name="password" minlength="8"  placeholder="Password" autofocus required/>
        </div><br>



          <div class="input-group">
          <button name="btn_login" class="btn">Log in</button>
          </div>

          <div class="d-flex align-items-center justify-content-center pb-4">
          <p align="center" class="login-register-text">Do not have an account?
          <a href="registerCust.php" >Register Here</a>.</p>
          </div>

          <div class="result text-center mb-0 text-danger"  id="result"  align="center" style="color: red"><p><?php echo $msg ?></p>
          </div>

        </div>
      </form>
    </form>
  </section>
</body>

