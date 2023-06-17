<?php
session_start();
include('../connection/connection.php');

if (isset($_SESSION["adminID"])) {
    $id = $_SESSION["adminID"];

} else {
    header('Location: ../indeAd.php');
}

$packageID = $_GET['packageID']; 


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
     echo"<meta http-equiv='refresh' content='0; url=managePack.php'/>";
}

?>
