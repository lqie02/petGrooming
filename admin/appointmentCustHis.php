<?php
session_start();
include('../connection/connection.php');

if (isset($_SESSION["adminID"])) {
    $id = $_SESSION["adminID"];
} else {
    header('Location: ../indexAd.php');
}

$limit = 10; // Number of entries per page
$page = isset($_GET['page']) ? $_GET['page'] : 1; // Current page number
$start = ($page - 1) * $limit; // Starting index for the query

if (isset($_GET['search_date'])) {
    $search_date = $_GET['search_date'];

    // Query to fetch orders based on the search date with pagination
    $sql = "SELECT * FROM orders o, customer c, appointment_detail ad WHERE o.customerID = c.customerID AND o.ordersID = ad.ordersID AND adminID = '$id' AND DATE(o.orderDate) = '$search_date' GROUP BY o.ordersID ORDER BY o.ordersID DESC LIMIT $start, $limit";

    $result = mysqli_query($conn, $sql);
    $counter = 1;
} else {
    // Default query to fetch all orders with pagination
    $sql = "SELECT * FROM orders o, customer c, appointment_detail ad WHERE o.customerID = c.customerID AND o.ordersID = ad.ordersID AND adminID = '$id' GROUP BY o.ordersID ORDER BY o.ordersID DESC LIMIT $start, $limit";

    $result = mysqli_query($conn, $sql);
    $counter = 1;
}

$countQuery = "SELECT COUNT(*) AS total FROM orders o, customer c, appointment_detail ad WHERE o.customerID = c.customerID AND o.ordersID = ad.ordersID AND adminID = '$id'";
$countResult = mysqli_query($conn, $countQuery);
$countRow = mysqli_fetch_assoc($countResult);
$totalEntries = $countRow['total'];
$totalPages = ceil($totalEntries / $limit);
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
    <h3><center>Customer Appointment History</center></h3>

    <div class="container">
        <a href="appointmentCust.php" class="btn btn-dark">Back</a> <br><br>

        <form method="GET" action="" class="mb-3">
            <div class="row mb-4">
                <div class="col-sm-2">
                    <input type="date" name="search_date" class="form-control" required>
                </div>
                <div class="col-sm-4">
                    <button type="submit" class="btn btn-primary">Search</button>
                    <a href="<?php echo $_SERVER['PHP_SELF']; ?>" class="btn btn-secondary" style="margin-left: 10px;">Reset</a>
                </div>
            </div>
        </form>

        <table class="table table-hover text-center">
            <thead class="table-dark">
                <tr>
                    <th scope="col" class="text-center">NO</th>
                    <th scope="col"><center>ORDER ID</center></th>
                    <th scope="col"><center>ORDERDATE</center></th>
                    <th scope="col"><center>CUSTOMER</center></th>
                    <th scope="col"><center>DETAILS</center></th> 
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    $rowNumber = $start + $counter;
                ?>
                    <tr>
                        <th><?php echo $rowNumber ?></th>
                        <th><center><?php echo $row['ordersID'] ?></center></th>
                        <th><center><?php echo $row['orderDate'] ?></center></th>
                        <th><center><?php echo $row['customerName'] ?></center></th>
                        <th><center><a href="custAppDetail.php?id=<?php echo $row['ordersID'] ?>" class="link-dark" style="text-decoration: none;"><i class="fa fa-download"></i>&nbsp;Details</a></center></th>
                    </tr>
                <?php
                    $counter++;
                }
                ?>
            </tbody>
        </table>

        <div class="d-flex justify-content-center">
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <?php if ($page > 1) : ?>
                        <li class="page-item"><a class="page-link" href="<?php echo $_SERVER['PHP_SELF'] . '?page=' . ($page - 1); ?>">Previous</a></li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                        <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>"><a class="page-link" href="<?php echo $_SERVER['PHP_SELF'] . '?page=' . $i; ?>"><?php echo $i; ?></a></li>
                    <?php endfor; ?>

                    <?php if ($page < $totalPages) : ?>
                        <li class="page-item"><a class="page-link" href="<?php echo $_SERVER['PHP_SELF'] . '?page=' . ($page + 1); ?>">Next</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>
</body>
</html>
