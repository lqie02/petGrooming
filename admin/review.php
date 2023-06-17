<?php
session_start();
include('../connection/connection.php');

if(isset($_SESSION["adminID"])) {
    $id = $_SESSION["adminID"];
} else {
    header('Location: ../indexAd.php');
   
}

// Define the number of entries per page
$entriesPerPage = 10;

// Handle package name search
if(isset($_GET['package_name'])) {
    $search = $_GET['package_name'];
    // Modify the SQL query to include the search condition
    $sql = "SELECT *
            FROM rating r
            INNER JOIN orders o ON r.ordersID = o.ordersID
            INNER JOIN package p ON p.packageID = r.packageID
            INNER JOIN customer c ON o.customerID = c.customerID
            WHERE p.packageName LIKE '%$search%'
            ORDER BY CASE WHEN p.animalType = 'Dog' THEN 1 WHEN p.animalType = 'Cat' THEN 2 END";
} else {
    // Default SQL query without search condition
    $sql = "SELECT *
            FROM rating r
            INNER JOIN orders o ON r.ordersID = o.ordersID
            INNER JOIN package p ON p.packageID = r.packageID
            INNER JOIN customer c ON o.customerID = c.customerID
            ORDER BY CASE WHEN p.animalType = 'Dog' THEN 1 WHEN p.animalType = 'Cat' THEN 2 END";
}

// Get the total number of entries
$totalEntries = mysqli_num_rows(mysqli_query($conn, $sql));

// Calculate the total number of pages
$totalPages = ceil($totalEntries / $entriesPerPage);

// Get the current page number
if(isset($_GET['page'])) {
    $currentPage = $_GET['page'];
} else {
    $currentPage = 1;
}

// Calculate the offset for the SQL query
$offset = ($currentPage - 1) * $entriesPerPage;

// Modify the SQL query to include the limit and offset
$sql .= " LIMIT $offset, $entriesPerPage";

$result = mysqli_query($conn, $sql);
$counter = $offset + 1;

?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="shortcut icon" type="image/png" href="../image/pets.png">
    <!--Bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!--font Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <title>Abby Shop</title>
</head>
<body>
    <?php include("headerAdmin.php"); ?>
    <br><br><br><br>
    <h3><center>Package Review</center></h3>

    <div class="container">
        <a href="managePack.php" class="btn btn-dark">Back</a> <br><br>
        
        <form method="get">
            <div class="row mb-4" >
                <div class="col-sm-2">
                    <input type="text" class="form-control" placeholder="Package name" name="package_name">
                </div>
                <div class="col-sm-4">
                    <button type="submit" class="btn btn-primary">Search</button>
                    <a href="<?php echo $_SERVER['PHP_SELF']; ?>" class="btn btn-secondary" style="margin-left: 10px;">Reset</a>
                </div>
            </div>
        </form>

        <table class="table table-bordered" style="border-color: black;">
            <thead class="table-info" style="border-color: black;">
                <tr>
                    <th scope="col" class="text-center">NO</th>
                    <th scope="col"><center>PACKAGE NAME</center></th>
                    <th scope="col"><center>CUSTOMER NAME</center></th>
                    <th scope="col"><center>FEEDBACK</center></th>
                    <th scope="col"><center>RATING</center></th> 
                </tr>
            </thead>
            <tbody>
                <?php
                while($row = mysqli_fetch_assoc($result)) {
                ?>
                    <tr>
                        <th><?php echo $counter ?></th>
                        <th><center><?php echo $row['packageName'] ?></center></th>
                        <th><center><?php echo $row['customerName'] ?></center></th>
                        <th><center><?php echo $row['r_remark'] ?></center></th>
                        <th><center><?php echo $row['score'] ?></center></th>
                    </tr>
                <?php
                    $counter++;
                }
                ?>
            </tbody>
        </table>

        <!-- Pagination links -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <?php
                // Generate pagination links
                for($i = 1; $i <= $totalPages; $i++) {
                    echo "<li class='page-item";
                    if($i == $currentPage) {
                        echo " active";
                    }
                    echo "'><a class='page-link' href='{$_SERVER['PHP_SELF']}?page=$i";
                    if(isset($_GET['package_name'])) {
                        echo "&package_name={$_GET['package_name']}";
                    }
                    echo "'>$i</a></li>";
                }
                ?>
            </ul>
        </nav>
    </div>
</body>
</html>
