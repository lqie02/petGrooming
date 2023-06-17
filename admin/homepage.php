<?php
session_start();
include('../connection/connection.php');
if(isset($_SESSION["adminID"]))
{
	$id= $_SESSION["adminID"];
}
else{
	header('Location: ../indexAd.php');
}

$sql = mysqli_query($conn,"SELECT COUNT(*) AS num FROM package");
$row = mysqli_fetch_assoc($sql);
	
$sql1 = mysqli_query($conn,"SELECT COUNT(*) AS num1 FROM product");
$row1 = mysqli_fetch_assoc($sql1);

$sql2 = mysqli_query($conn,"SELECT COUNT(*) AS num2 FROM supplier");
$row2 = mysqli_fetch_assoc($sql2);

$sql3 = mysqli_query($conn,"SELECT COUNT(*) AS num3 FROM orders WHERE ordersID IN (SELECT ordersID FROM appointment_detail WHERE status = 'Pending' ORDER BY ordersID )");
$row3 = mysqli_fetch_assoc($sql3);

$sql4 = mysqli_query($conn,"SELECT COUNT(*) AS num4 FROM orders WHERE ordersID IN (SELECT ordersID FROM product_detail WHERE p_status = 'Pending' ORDER BY ordersID )");
$row4 = mysqli_fetch_assoc($sql4);

$sql5 = mysqli_query($conn,"SELECT COUNT(*) AS num5 FROM product WHERE stockQuantity <=10");
$row5 = mysqli_fetch_assoc($sql5);

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="shortcut icon" type="image/png" href="../image/pets.png">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
<link rel="stylesheet" href="../css/homepage.css" >
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<title>Abby Shop</title>
</head>

<body>
	<?php include('headerAdmin.php'); ?>
    <div class="d-flex" id="wrapper" style="padding-top: 90px;" >
        <!-- Page Content -->
        <div id="page-content-wrapper">           
            <div class="container-fluid px-5">  
				
				<div class="row g-3 my-2">
                    <div class="col-md-3" style="margin-right: 30px;">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                            <div>
                                <h3 class="fs-2"><center><?php echo $row['num'] ?></center></h3>
                                <p class="fs-5">Packages</p>
                            </div>
                            <i class="fa-solid fa-scissors fs-1 primary-text  rounded-full secondary-bg p-3 "style="color: #D5591F;"></i>
                        </div>
                    </div>

                    <div class="col-md-3" style="margin-right: 30px;">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                            <div>
                                <h3 class="fs-2"><center><?php echo $row1['num1'] ?></center></h3>
                                <p class="fs-5">Products</p>
                            </div>
                            <i
                                class="fas fa-gift fs-1 primary-text  rounded-full secondary-bg p-3"></i>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                            <div>
                                <h3 class="fs-2"><center><?php echo $row2['num2'] ?></center></h3>
                                <p class="fs-5">Suppliers</p>
                            </div>
                            <i class="fa-solid fa-user-tie fs-1 primary-text  rounded-full secondary-bg p-3"></i>
                        </div>
                    </div>
                </div>
<br><br>
                
				
				<div class="row my-5">
                    <div class="col-md-3" style="margin-right: 30px;">
                        <h3 class="fs-4 mb-4">Notice :</h3>
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                            <div>
                                <h3 class="fs-2"><center><?php echo $row3['num3'] ?></center></h3>
                                <p class="fs-5">Pending to Approval</p>
                            </div>
                            <i class="fa-solid fa-scissors fs-1 primary-text rounded-full secondary-bg p-3 "style="color: #D5591F;"></i>
                        </div>
                    </div>
					
                    <div class="col-md-3" style="margin-right: 30px;margin-top: 55px;">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                            <div>
                                <h3 class="fs-2"><center><?php echo $row4['num4'] ?></center></h3>
                                <p class="fs-5">Pending to Approve</p>
                            </div>
                            <i class="fas fa-gift fs-1 primary-text rounded-full secondary-bg p-3"></i>
                        </div>
                    </div>
					
                    <div class="col-md-3" style="margin-top: 55px;">    
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                            <div>
                                <h3 class="fs-2"><center><?php echo $row5['num5'] ?></center></h3>
                                <p class="fs-5">Low stock product</p>
                            </div>
                            <i class="fas fa-gift fs-1 primary-text rounded-full secondary-bg p-3"></i>
                        </div>
                    </div>
                </div>
				
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
</body>