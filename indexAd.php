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
    $time=time()-30;
    $ip_address=getIpAddr();
    
    $query = mysqli_query($conn, "select count(*) as total_count from loginlogs where TryTime > $time and IpAddress='$ip_address'"); 
      $check_login_row=mysqli_fetch_assoc($query);
      $total_count=$check_login_row['total_count'];
    
    //checking when the attempts exceed three,wait 15 sec to login again
    if($total_count == 3)
    {
        $msg="To many failed login attempts. Please login after 30 sec.";
    }
    else
    {
        //Getting Post Values
    $email = test_input($_POST['email']);
    $password = test_input($_POST['password']);
    $role = test_input($_POST['role']);

    $password = md5($password);
  
      switch ($role) {
      case "Admin":
      $sql ="SELECT * FROM admin WHERE adminEmail = '".$email."' AND adminPassword = '".$password."'";
 
      //$result = mysqli_query($conn, $sql);
      $result = mysqli_query($conn,$sql);
    
      if(mysqli_num_rows($result) > 0)
      {
        $row = mysqli_fetch_assoc($result);
 
        $_SESSION['adminID'] = $row["adminID"];
        $_SESSION['adminName'] = $row['adminName'];
        $_SESSION['adminEmail'] = $row['adminEmail'];
        $_SESSION['adminTelephone'] = $row['adminTelephone'];
        $_SESSION['adminPassword'] = $row['adminPassword'];
        $_SESSION['Active_Time'] = time();
 
        mysqli_query($conn,"delete from loginlogs where IpAddress='$ip_address'");
        echo "<script>alert('Login Success!');</script>";
        echo"<meta http-equiv='refresh' content='0; url=admin/homepage.php'/>";
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
              $msg="Email or Password or Role was wrong.<br/>$rem_attm attempts remaining";
            }
            $try_time=time();
            mysqli_query($conn,"INSERT INTO loginlogs(IpAddress,TryTime) values('$ip_address','$try_time')");
      } 
      break;
    
      case "Supplier":
      $sql ="SELECT * FROM supplier WHERE s_email = '".$email."' AND s_password = '".$password."'";
 
      $result = mysqli_query($conn,$sql);
    
      if(mysqli_num_rows($result) > 0)
      {
        $row = mysqli_fetch_assoc($result);
 
        $_SESSION['supplierID'] = $row["supplierID"];
        $_SESSION['supplierName'] = $row['supplierName'];
        $_SESSION['companyName'] = $row['companyName'];
        $_SESSION['s_address'] = $row['s_address'];
        $_SESSION['s_email'] = $row['s_email'];
        $_SESSION['s_telephone'] = $row['s_telephone'];
        $_SESSION['s_password'] = $row['s_password'];
		$_SESSION['adminID'] = $row['adminID'];
        $_SESSION['Active_Time'] = time();
        
        mysqli_query($conn,"delete from loginlogs where IpAddress='$ip_address'");  
        echo "<script>alert('Login Success!');</script>";
        echo"<meta http-equiv='refresh' content='0; url=supplier/sup_pro.php'/>";
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
              $msg="Email or Password or Role was wrong.<br/>$rem_attm attempts remaining";
            }
            $try_time=time();
            mysqli_query($conn,"INSERT INTO loginlogs(IpAddress,TryTime) values('$ip_address','$try_time')");
      }
       break;
 
      default: 
      echo "<script>alert('Please select role');</script>";
      echo"<meta http-equiv='refresh' content='0; url=indexAd.php'/>";
      break;
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

  <div class="container">
    <form action="" method="POST" class="login-email">
      <p align="center" class="login-text" style="font-size: 2rem; font-weight: 800;">Login</p>
      <br>
        <p align="justify">Please login to your account : </p><br>

        <div class="input-group">
          <input type="email" name="email" placeholder="Email address" autofocus required/>
        </div>

        <div class="input-group">
          <input type="password" name="password" minlength="8"  placeholder="Password" autofocus required/>
        </div>
		
		<div class="form-group">
        	<label class = "col-sm-3 control-label"> &nbsp;Select role&nbsp;&nbsp;</label>
        	<select class="form-control" name="role" autofocus required>
          	<option selected="true" disabled="disabled" value="">- Select role -</option >
          	<option value="Admin">Admin</option>
          	<option value="Supplier">Supplier</option>
          	</select>
        </div></br>

          <div class="input-group">
          <button name="btn_login" class="btn">Log in</button>
          </div>

          <div class="result text-center mb-0 text-danger"  id="result"  align="center" style="color: red"><p><?php echo $msg ?></p>
          </div>

        </div>
      </form>
    </form>
  </section>
</body>

