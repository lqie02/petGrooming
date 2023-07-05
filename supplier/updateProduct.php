<?php
session_start();
include('../connection/connection.php');

if (isset($_SESSION["supplierID"])) {
    $id = $_SESSION["supplierID"];
} else {
    // Redirect if not logged in
    header('Location: ../indexAd.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the submitted form data
    $productID = $_POST['productID'];
    $productName = $_POST['productName'];
    $cName = $_POST['cName'];
    $addStock = $_POST['addStock'];
    $p_unitPrice = $_POST['p_unitPrice'];
    $d_description = $_POST['d_description'];

    // Update the product information in the database
    $sql = "UPDATE product SET productName = '$productName', categoryID = '$cName',  p_unitPrice = '$p_unitPrice' , d_description = '$d_description'  WHERE productID = '$productID'";
    $result = mysqli_query($conn, $sql);

    // Check if the update was successful
    if ($result) {
        // Check if a new image was uploaded
        if ($_FILES['productImage']['name']) {
            $imageName = $_FILES['productImage']['name'];
            $imageTmpName = $_FILES['productImage']['tmp_name'];

            // Process the uploaded image
            $imageData = addslashes(file_get_contents($imageTmpName)); // Addslashes to handle special characters

            // Update the image in the database
            $sql = "UPDATE product SET pro_image = '$imageData' WHERE productID = '$productID'";
            $result = mysqli_query($conn, $sql);

            // Check if the image update was successful
            if ($result) {
                // Image update successful

                // Insert data into the supply table
                $sql = "INSERT INTO supply (supplierID, productID, supplyDate, s_quantity) VALUES ('$id', '$productID', NOW(), '$addStock')";
                $result = mysqli_query($conn, $sql);

                // Check if the supply data insertion was successful
                if ($result) {
                    // Supply data insertion successful
                    echo "<script>alert('Product information and image have been updated successfully');</script>";
                    echo "<meta http-equiv='refresh' content='0; url=sup_pro.php'/>";
                } else {
                    // Supply data insertion failed
                    echo "<script>alert('Error inserting supply data: " . mysqli_error($conn) . "');</script>";
                    echo "<meta http-equiv='refresh' content='0; url=sup_pro.php'/>";
                }
            } else {
                // Image update failed
                echo "<script>alert('Error updating the product image: " . mysqli_error($conn) . "');</script>";
                echo "<meta http-equiv='refresh' content='0; url=sup_pro.php'/>";
            }
        } else {
            // Image was not uploaded, only package information was updated

            // Insert data into the supply table
            $sql = "INSERT INTO supply (supplierID, productID, supplyDate, s_quantity) VALUES ('$id', '$productID', NOW(), '$addStock')";
            $result = mysqli_query($conn, $sql);

            // Check if the supply data insertion was successful
            if ($result) {
                // Supply data insertion successful
                echo "<script>alert('Product information has been updated successfully');</script>";
                echo "<meta http-equiv='refresh' content='0; url=sup_pro.php'/>";
            } else {
                // Supply data insertion failed
                echo "<script>alert('Error inserting supply data: " . mysqli_error($conn) . "');</script>";
                echo "<meta http-equiv='refresh' content='0; url=sup_pro.php'/>";
            }
        }
    } else {
        // Update Product
        echo "<script>alert('Error updating the product information: " . mysqli_error($conn) . "');</script>";
        echo "<meta http-equiv='refresh' content='0; url=sup_pro.php'/>";
    }
} else {
    // Invalid request method
    echo "Invalid request method.";
}
?>
