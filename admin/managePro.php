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

?>

<!doctype html>
<html lang="en" dir="ltr">
<head>
<meta charset="utf-8">
    <link rel="shortcut icon" type="image/png" href="../image/pets.png">
    
    <!--Bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
   <!--font Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    
    <title>Manage Product</title>
    <style>
  	.image 
	{
    	width: 150px;
    	height: 150px;
  	}
		 
	.toast-container 
	{
       display: flex;
       justify-content: center;
       align-items: flex-start;
       margin-left: 100px;
	   background-color: red;
       
    }

    .toast 
	{
        max-width: none;
        width: auto;
    }
	 .bold-product-name 
	{
        font-weight: bold;
    }
	.low-stock-row 
	{
   		background-color: #ffcccc; /* Set the red background color */
  	}

</style>

</head>
    
<body>

    
    <?php include("headerAdmin.php") ?><br><br><br><br><br><br>
	<div class="toast-container">
    <div class="toast" id="lowStockToast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto" style="color: red">Low Stock Alert</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body bold-product-name" id="lowStockMessage"></div>
    </div>
</div>


  
    <div class="container">
        <br><br><br><br><br><br>
        
            <table  class="table table-bordered" style="border-color: black;">
              <thead class="table-info" style="border-color: black;">
                <tr >
                  <th scope="col" class="text-center">ID</th>
                  <th scope="col">PRODUCT NAME</th>
                  <th scope="col"><center>IMAGE</center></th>
                  <th scope="col"><center>CATEGORY</center></th>
                  <th scope="col"><center>STOCK QUANTITY</center></th>
                  <th scope="col"><center>PRICE (RM)</center></th>
                  <th scope="col"><center>DESCRIPTION</center></th> 
				  <th scope="col"><center>SUPPLIER</center></th>
                </tr>
              </thead>
              <tbody>
                   <?php
        $lowStockProducts = ''; // New variable to store low stock products
        $sql = "SELECT * FROM product p, category c, supplier s WHERE p.categoryID=c.categoryID AND p.supplierID=s.supplierID ORDER BY CASE WHEN c.cName = 'Dog' THEN 1 WHEN c.cName = 'Cat' THEN 2 END";
        $result = mysqli_query($conn,$sql);
        while($row = mysqli_fetch_assoc($result))
        { 
            $rowClass = '';
        		if ($row['stockQuantity'] < 10) {
          			$rowClass = 'low-stock-row';
          			$lowStockProducts .= $row['productName'] . ', ';
        }
        ?>
            <tr class="<?php echo $rowClass; ?>">
                <th><?php echo $row['productID'] ?></th>
                <th ><?php echo $row['productName'] ?></th>
                <th><?php echo '<img class="image" src="data:image/jpeg;base64,'.base64_encode($row['pro_image']).'" />'; ?></th>
                <th><center><?php echo $row['cName'] ?></center></th>
                <th><center><?php echo $row['stockQuantity'] ?></center></th>
                <th><center><?php echo $row['p_unitPrice'] ?></center></th>
                <th><?php echo $row['d_description'] ?></th>
				<th><a href="mailto:<?php echo $row['s_email']; ?>"><?php echo $row['companyName'] ?></a></th>
            </tr>
            
        <?php
        }
       
        ?>
                
              </tbody>
        </table>
  
    </div>
    
    <!--bootsrap-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
	<script>
    var lowStockProducts = "<?php echo $lowStockProducts; ?>";
    if (lowStockProducts !== "") {
        var lowStockMessage = document.getElementById("lowStockMessage");
        lowStockMessage.textContent = "The following products have a quantity less than 10: " + lowStockProducts;

        var lowStockToast = new bootstrap.Toast(document.getElementById('lowStockToast'));
        lowStockToast.show();

        lowStockToast._config.animation = false; // Disable the toast auto-hide animation
        lowStockToast._config.autohide = false; // Prevent the toast from auto-hiding
    }
</script>


    
</body>
</html>