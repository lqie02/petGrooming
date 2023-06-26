<?php
session_start();
include('../connection/connection.php');

if (isset($_SESSION["adminID"])) {
    $id = $_SESSION["adminID"];
} else {
    header('Location: ../indeAd.php');
}

$packageID = $_GET['packageID']; 

$sql = "SELECT * FROM appointment_detail WHERE packageID = '$packageID'";
$result = mysqli_query($conn,$sql);

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Delete Package</title>
    <link rel="shortcut icon" type="image/png" href="../image/pets.png">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <style>
        .error-message {
            background-color: #ffcccc;
            color: #ff0000;
            padding: 10px;
            margin-top: 10px;
            border: 1px solid #ff0000;
            border-radius: 4px;
			margin-left: 10px;
			margin-right: 10px;
			margin-bottom: 10px;
        }
    </style>
</head>
<body>
<?php
if(mysqli_num_rows($result) > 0) { ?>
    <div class="error-message">Cannot delete the package.</div>
    <button onclick="goBack()" class="btn btn-secondary" style="margin-left: 10px">Back</button>
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
<?php } else {
    // Prepare and execute the stored procedure call
    $query = "CALL delete_package(?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $packageID);
    $stmt->execute();

    // Check if the procedure execution was successful
    if ($stmt->error) {
        // Procedure execution failed
        echo "Error executing stored procedure: " . $stmt->error;
    } else {
        // Procedure executed successfully
        $result = $stmt->get_result();
        echo "<script>alert('Delete package successfully');</script>";
        echo "<meta http-equiv='refresh' content='0; url=managePack.php'/>";
    }
}

?>
</body>
</html>
