<?php
include("../connection/connection.php");
 session_start();
  if (isset($_SESSION["adminID"])) {
    $id = $_SESSION["adminID"];
  } else {
    header("Location: ../indexAd.php");
    exit();
  }
if (isset($_GET['id'])) {
    $orderid = $_GET['id'];
} else {
    // handle the case where the "orderid" key is not set
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" type="image/png" href="../image/pets.png">
<title>Abby Shop </title>
<script src="https://raw.githack.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
<!-- Web Fonts
======================= -->
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900' type='text/css'>

<!-- Stylesheet
======================= -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
<script src="https://use.fontawesome.com/65eb163cd4.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>
</head>
<body>

<?php
	
	$query = "SELECT * FROM payment p, orders o, customer c, appointment_detail a, package d WHERE p.ordersID=o.ordersID AND a.ordersID=o.ordersID AND a.packageID=d.packageID AND o.customerID=c.customerID AND p.ordersID =$orderid";
	$result = mysqli_query($conn,$query);
	if(mysqli_num_rows($result)>0)
	{
		$row = mysqli_fetch_assoc($result)
		
	?>
<!-- Container -->
<div class="container-fluid invoice-container" id="invoice" style="margin-top: 20px;">

  <!-- Header -->
  <header>
  <div class="row align-items-center">
    <div class="col-sm-7 text-center text-sm-left mb-3 mb-sm-0">
      <img id="logo" src="../image/logo1.png" title="Ospoly" alt="ABBY Logo" style="width: 15%; height: 15%;"/>
    </div>
    <div class="col-sm-5 text-center text-sm-right">
      <h4 class="text-7 mb-0">Receipt</h4>
    </div>
  </div>
  <hr style="background-color: green;">
  </header>
  
  <!-- Main Content -->
  <main  id="receipt">
  <div class="row">
    <div class="col-sm-6"><strong>Date:</strong> <?php echo $row['paymentDate']; ?> </div>
    <div class="col-sm-6 text-sm-right"> <strong>Reference No:</strong> <?php echo $row['paymentID']; ?></div>
    
  </div>
  <div class="row">
    <div class="col-sm-12 text-sm-center"><h3 style="padding-top: 15px;">RECEIPT ABBY SHOP </h3></div>
    
  </div>
  <hr style="background-color: black;">
  <div class="row">
    <div class="col-sm-6 text-sm-right order-sm-1"> <strong>ABBY SHOP :</strong>
      <address>
      Bukit Beruang Utama 1<br />
	  Ayer Keroh, 75450 Melaka<br />
      (+601) 155485712 <br />
      laurentan@gmail.com

      </address>
    </div>
     
    <div class="col-sm-6 order-sm-0"> <strong>Payment By:</strong>
      <address>
      NAME: <?php echo $row['customerName']; ?><br />
      EMAIL: <?php echo $row['email']; ?><br />
      TELEPHONE: <?php echo $row['telephone']; ?><br />
	  ADDRESS: <?php echo $row['cAddress']; ?><br />
      
      </address>
    </div>
  </div>
  
  <div class="card">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table mb-0">
    <thead class="card-header">
          <tr>
            <td class="col-3 border-0"><strong>	No.</strong></td>
      <td class="col-4 border-0"><strong>Description</strong></td>
            <td class="col-2 text-center border-0"><strong>Unit Price</strong></td>
      <td class="col-1 text-center border-0"><strong>QTY</strong></td>
            <td class="col-2 text-right border-0"><strong>Amount</strong></td>
          </tr>
        </thead>
          <tbody>
			  <?php 
				$query1 = "SELECT * FROM payment p, orders o, customer c, appointment_detail a, package d WHERE p.ordersID=o.ordersID AND a.ordersID=o.ordersID AND a.packageID=d.packageID AND o.customerID=c.customerID AND p.ordersID =$orderid";
	$result1 = mysqli_query($conn,$query1);
	if(mysqli_num_rows($result1)>0)
	{ $counter=1;
		while($row1 = mysqli_fetch_assoc($result1))
		{ 
				?>
            <tr>
          
			<td class="col-4 text-1 border-0" style="background-color: #dcd8cf;color: #000;"><?php echo $counter ?></td>
              <td class="col-4 text-1 border-0" style="background-color: #dcd8cf;color: #000;"><?php echo $row1['packageName']; ?></td>
              <td class="col-2 text-center border-0" style="background-color: #dcd8cf;color: #000;">RM <?php echo $row1['unitPrice']; ?></td>
        <td class="col-1 text-center border-0" style="background-color: #dcd8cf;color: #000;"><?php echo $row1['quantity']; ?></td>
        <td class="col-2 text-right border-0" style="background-color: #2264c4;color: #fff;">RM <?php echo number_format($row1['unitPrice'] * $row1['quantity'],2); ?></td>
            </tr> <?php $counter++;} } ?>
     
          </tbody>
      <tfoot class="card-footer">
            <tr>
              <td colspan="4" class="text-right"><strong>Sub Total:</strong></td>
              <td class="text-right">RM <?php echo $row['totalAmount']  ?></td>
            </tr>
            <tr>
              <td colspan="4" class="text-right"><strong>Service Charge (10%) :</strong></td>
              <td class="text-right">RM <?php echo $row['serviceCharge']; ?></td>
            </tr>
            <tr>
              <td colspan="4" class="text-right"><strong>Total:</strong></td>
              <td class="text-right">RM <?php echo $row['amountAfterCharge']; ?></td>
            </tr>
      
      </tfoot>
        </table>
      </div>
    </div>
  </div>

  </main>
  <!-- Footer -->
  <footer class="text-center mt-4">
  
 
  <div class="btn-group btn-group-sm d-print-none"> 
  <a href="javascript:window.print()" class="btn btn-light border text-black-50 shadow-none"><i class="fa fa-print"></i> Print</a> 
  <a href="#" id="download" class="btn btn-light border text-black-50 shadow-none"><i class="fa fa-download"></i> Download</a> 
  <a href="appointmentCustHis.php" class="btn btn-light border text-black-50 shadow-none"><i class="fa fa-chevron-left"></i> Back</a>   
  </div>
  </footer> 

</div> <?php }   ?>


<script>
	window.onload = function(){
  		document.getElementById("download")
  		.addEventListener("click",()=> {
   		const invoice = this.document.getElementById("invoice");
 		var opt = {
  
  		image:        { type: 'jpeg', quality: 0.98 },
  		html2canvas:  { scale: 2 },
  		jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
		};
   			html2pdf().from(invoice).set(opt).save();
  })
}
        
</script>
</body>
</html>