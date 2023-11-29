<?php
session_start();

// Check if the user is not authenticated
if (!isset($_SESSION["Name"])) {
    header("Location: login.php"); // Redirect to the login page
    exit; // Ensure the script exits to prevent further execution
}
include 'connection.php';

// Your SQL query
$selectQuery = "SELECT
    mo.*,
    ta.assignment_date,
    ta.tailor_id,
    ta.created_date,
    ta.rate,
    ta.quantity AS assigned_quantity,
    (mo.`ORDER QTY` - IFNULL(SUM(ta.quantity), 0)) AS pending_quantity
FROM
    manage_order mo
LEFT JOIN tailor_assign ta ON mo.`ORDER NUMBER` = ta.order_no
GROUP BY mo.`ORDER NUMBER`";

$sqlAssign = "SELECT COUNT(*) AS tailor_assign_count FROM tailor_assign";
$sqltailor = "SELECT COUNT(*) AS tailor_count FROM manage_tailor";
$sqlstaff = "SELECT COUNT(*) AS staff_count FROM manage_staff";
// Execute the query
$tailorcount = mysqli_query($conn, $sqltailor);
$staffcount = mysqli_query($conn, $sqlstaff);
// Execute the query
$result = mysqli_query($conn, $selectQuery);

if ($result) {
    $totalOrders = mysqli_num_rows($result);

    $pendingOrders = 0;
    $completedOrders = 0;

    while ($row = mysqli_fetch_assoc($result)) {
        $pendingQuantity = $row['pending_quantity'];

        if ($pendingQuantity > 0) {
            $pendingOrders++;
        } else {
            $completedOrders++;
        }
    }


} else {
    // Handle the case where the query fails
    echo "Error: " . mysqli_error($conn);
}

if ($tailorcount) {
    $row = mysqli_fetch_assoc($tailorcount);
    $tailorCount = $row['tailor_count'];
} else {
    // Handle the case where the query fails
    echo "Error: " . mysqli_error($conn);
}

if ($staffcount) {
    $row = mysqli_fetch_assoc($staffcount);
    $staffCount = $row['staff_count'];
} else {
    // Handle the case where the query fails
    echo "Error: " . mysqli_error($conn);
}

// Execute the query
$assignCount = mysqli_query($conn, $sqlAssign);

if ($assignCount) {
    $row = mysqli_fetch_assoc($assignCount);
    $tailorAssignCount = $row['tailor_assign_count'];
} else {
    // Handle the case where the query fails
    echo "Error: " . mysqli_error($conn);
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include 'includes/head.php';
    ?>
</head>

<body>

    <?php
    include 'includes/header.php';
    ?>
    </div>


    <div class="col-md-12  scrollable-content">
        <div class="container   ">
            <!-- //this is 1st row // -->
            <div class="row mt-3">
                <div class="col-md-4 ">
                    <div class="card w-100 mb-4 dashboard_total">
                        <div class="card-body">
                            <?php echo $totalOrders; ?>
                        </div>
                        <div class="pb-5 ms-3 ">Total Orders</div>
                    </div>
                </div>
                <div class="col-md-4 ">
                    <div class="card w-100 mb-4 dashboard_pending">
                        <div class="card-body">
                            <?php echo $pendingOrders; ?>
                        </div>
                        <div class=" pb-5 ms-3">Pending Orders</div>
                    </div>
                </div>
                <div class="col-md-4 ">
                    <div class="card w-100 mb-4 dashboard_completed">
                        <div class="card-body">
                            <?php echo $completedOrders; ?>
                        </div>
                        <div class=" pb-5 ms-3 ">
                            completed Orders
                        </div>
                    </div>
                </div>
            </div>
            <!-- //this is 2nd row // -->
            <div class="row">
                <div class="col-md-4 pt-2">
                    <div class="card w-100 mb-4 dashboard_total">
                        <div class="card-body">
                            <?php echo $tailorAssignCount; ?>
                        </div>
                        <div class=" pb-5 ms-3 ">Assigned Order</div>
                    </div>
                </div>
                <div class="col-md-4 pt-2">
                    <div class="card w-100 mb-4 dashboard_total">
                        <div class="card-body">
                            <?php echo $tailorCount; ?>
                        </div>
                        <div class=" pb-5 ms-3">Total Tailor</div>
                    </div>
                </div>
                <div class="col-md-4 pt-2">
                    <div class="card w-100 mb-5 dashboard_completed">
                        <div class="card-body">
                            <?php echo $staffCount; ?>

                        </div>
                        <div class=" pb-5 ms-3">No of Staff</div>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <?php
    include 'includes/script.php';
    ?>
</body>

</html>