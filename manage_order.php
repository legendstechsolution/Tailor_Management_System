<?php
session_start();

// Check if the user is not authenticated
if (!isset($_SESSION["Name"])) {
    header("Location: login.php"); // Redirect to the login page
    exit; // Ensure the script exits to prevent further execution
}
include 'connection.php';
// Determine records per page from POST or GET data
$recordsPerPage = (isset($_POST['recordsPerPage']) ? intval($_POST['recordsPerPage']) : (isset($_GET['itemsPerPage']) ? intval($_GET['itemsPerPage']) : 10));
// Get the current page from the URL
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

// Calculate the offset for the SQL query
$offset = ($page - 1) * $recordsPerPage;

// SQL query to retrieve data with pagination$query = "SELECT * FROM manage_order ORDER BY `ID` DESC LIMIT $recordsPerPage OFFSET $offset";
$query = "SELECT * FROM manage_order ORDER BY `ID` DESC LIMIT $recordsPerPage OFFSET $offset";

$result = $conn->query($query);

// Count the total number of rows
$countQuery = "SELECT COUNT(*) AS total_rows FROM manage_order";
$countResult = $conn->query($countQuery);
$rowCount = $countResult->fetch_assoc();
$totalRows = $rowCount['total_rows'];
$totalPages = ceil($totalRows / $recordsPerPage);



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
    <div id="loader-container">
        <div id="loader"></div>
    </div>



    <div class="col-md-12  scrollable-content">
        <div class="container card  mt-3">
            <div class="row">
                <div class="col-md-6 pt-3 ps-4">
                    <p>Manage Order</p>
                </div>
                <div class="col-md-6 text-md-end mt-2">
                    <div class="row d-flex justify-content-end">
                        <div class="col-md-auto ">
                            <a class="btn btn-warning me-2 mt-2 ">Print</a>
                            <p class="d-inline">Row Per Page</p>
                            <form class="d-inline" method="post">

                                <div class="dropdown d-inline">

                                    <select id="dropdownlist" name="recordsPerPage" onchange="this.form.submit()">
                                        <option value="1" <?php if ($recordsPerPage === 1)
                                            echo 'selected'; ?>>1</option>
                                        <option value="2" <?php if ($recordsPerPage === 2)
                                            echo 'selected'; ?>>2</option>
                                        <option value="5" <?php if ($recordsPerPage === 5)
                                            echo 'selected'; ?>>5</option>
                                        <option value="10" <?php if ($recordsPerPage === 10)
                                            echo 'selected'; ?>>10</option>
                                        <option value="20" <?php if ($recordsPerPage === 20)
                                            echo 'selected'; ?>>20</option>
                                        <option value="50" <?php if ($recordsPerPage === 50)
                                            echo 'selected'; ?>>50</option>
                                    </select>
                                </div>
                            </form>

                        </div>

                        <div class="col-md-auto">
                            <div class="mt-2 ms-2">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination">
                                        <?php
                                        if ($page > 1) {
                                            echo '<li class="page-item"><a class="page-link" href="manage_order.php?page=' . ($page - 1) . '&itemsPerPage=' . $recordsPerPage . '">Previous</a></li>';
                                        }

                                        for ($i = 1; $i <= $totalPages; $i++) {
                                            if ($i === 1 || $i === $totalPages || $i === 7 || $i === 10 || $i >= 2 && $i <= 4 || $i >= 7 && $i <= 10 || abs($i - $page) < 3) {
                                                echo '<li class="page-item';
                                                if ($i === $page) {
                                                    echo ' active';
                                                }
                                                echo '"><a class="page-link" href="manage_order.php?page=' . $i . '&itemsPerPage=' . $recordsPerPage . '">' . $i . '</a></li>';
                                            } elseif (($i === 5 && $page > 5) || ($i === ($totalPages - 4) && $page < ($totalPages - 4))) {
                                                echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                                            }
                                        }

                                        if ($page < $totalPages) {
                                            echo '<li class="page-item"><a class="page-link" href="manage_order.php?page=' . ($page + 1) . '&itemsPerPage=' . $recordsPerPage . '">Next</a></li>';
                                        }
                                        ?>
                                    </ul>
                                </nav>


                            </div>
                        </div>

                    </div>
                </div>

                <div class="line mt-1 mb-3" style="border: 1px solid rgb(210, 210, 210);"></div>
                <div class="row  mb-3">
                    <div class="col-md-6">
                        <input type="text" class="form-control w-100" placeholder="Search" id="searchInput">
                    </div>
                    <div class="col-md-6  text-end">
                        <a href="create_order.php" class="btn btn-primary add "><b>CREATE ORDER</b></a>
                        <a class="btn btn-primary order" id="toggleOrders"><b>SHOW PENDING ORDER</b></a>
                    </div>
                </div>

                <div class=" fixTableHead mb-3 ">
                    <table class="table table-bordered text-center">
                        <thead class="table-secondary">
                            <tr>
                                <th>SI.NO</th>
                                <th>EDIT</th>
                                <th>DELETE</th>
                                <th>ORDER ASSIGN</th>
                                <th>STATUS</th>
                                <th>ORDER DATE</th>
                                <th>ORDER NUMBER</th>
                                <th>JC NO</th>
                                <th>FUNCTION NAME</th>
                                <th>FUNCTION DATE</th>
                                <th>PERSON NAME</th>
                                <th>SELVAN</th>
                                <th>SELVI</th>
                                <th>PLACE</th>
                                <th>MOBILE NUMBER</th>
                                <th>ITEM NAME</th>
                                <th>SIZE</th>
                                <th>MODEL</th>
                                <th>EXTRA DETAIL</th>
                                <th>HANDLE</th>
                                <th>PRINTING COLOR</th>
                                <th>SIDE PATTI COLOR</th>
                                <th>ORDER QTY</th>
                                <th>RATE</th>
                                <th>AMOUNT</th>
                                <th>DTP CHARGES</th>
                                <th>TOTAL</th>
                                <th>GST%</th>
                                <th>GST VALUE</th>
                                <th>GRAND TOTAL</th>
                                <th>ADVANCE</th>
                                <th>DISCOUNT</th>
                                <th>BALANCE TO PAY</th>
                                <th>FINAL AMOUNT PAID</th>
                                <th>ADVANCE AMOUNT METHOD</th>
                                <th>FINAL AMOUNT METHOD</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $siNo = 1;
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    // Extract data from $row
                                    $orderQty = floatval($row["ORDER QTY"]);
                                    $rate = floatval($row["RATE"]);
                                    $dtpCharges = floatval($row["DTP CHARGES"]);
                                    $gstPercent = floatval($row["GST%"]);
                                    $advanceAmount = floatval($row["ADVANCE"]);
                                    $discountAmount = floatval($row["DISCOUNT"]);
                                    $finalaount = floatval($row["final_amount_paid"]);
                                    // Perform calculations
                                    $amount = $orderQty * $rate;
                                    $total = $amount + $dtpCharges;
                                    $gstValue = ($total * $gstPercent) / 100;
                                    $grantTotalValue = $amount + $dtpCharges + $gstValue;
                                    $balanceToPayValue = $grantTotalValue - $advanceAmount - $finalaount;
                                    ?>
                                    <tr>
                                        <td>
                                            <?= $siNo ?>
                                        </td>
                                        <td>
                                            <a href="create_order.php?id=<?= $row['ID']; ?>">
                                                <i class="fa fa-edit "></i>
                                            </a>
                                        <td>
                                            <a href='deleteorder.php?id=<?= $row["ID"] ?>'
                                                onclick="return confirm('Are you sure you want to delete this order?')">
                                                <i class='fa fa-trash-o'></i>
                                            </a>
                                        </td>

                                        <td>
                                            <a href="assignmodel.php?orderno=<?= $row["ORDER NUMBER"] ?>">
                                                <i class="fa fa-user-plus order-assign cursor-pointer"></i>

                                            </a>
                                        </td>


                                        <td>
                                            <?php
                                            // Calculate the remaining quantity based on the order quantity and assigned quantity
                                            $assignedQuantity = 0; // Initialize the assigned quantity to zero
                                            $assignmentQuery = "SELECT SUM(quantity) AS assigned_quantity FROM tailor_assign WHERE order_no = '" . $row["ORDER NUMBER"] . "'";
                                            $assignmentResult = $conn->query($assignmentQuery);

                                            if ($assignmentResult && $assignmentResult->num_rows > 0) {
                                                $assignedData = $assignmentResult->fetch_assoc();
                                                $assignedQuantity = $assignedData['assigned_quantity']; // Use the alias assigned_quantity
                                            }

                                            // Assuming $row["ORDER QTY"] contains the total order quantity
                                            $statusClass = ($assignedQuantity < $row["ORDER QTY"]) ? 'btn-danger' : 'btn-success';
                                            $statusText = ($assignedQuantity < $row["ORDER QTY"]) ? 'pending' : 'completed';
                                            ?>
                                            <button class="btn <?= $statusClass ?>">
                                                <?= $statusText ?>
                                            </button>
                                        </td>

                                        <td>
                                            <?= date("d-m-Y", strtotime($row["ORDER DATE"])) ?>
                                        </td>

                                        <td>
                                            <?= $row["ORDER NUMBER"] ?>
                                        </td>
                                        <td>
                                            <?= $row["JC NO"] ?>
                                        </td>
                                        <td>
                                            <?= $row["FUNCTION NAME"] ?>
                                        </td>
                                        <td class="col-3">
                                            <?= date("d-m-Y", strtotime($row["FUNCTION DATE"])) ?>
                                        </td>
                                        <td>
                                            <?= $row["PERSON NAME"] ?>
                                        </td>
                                        <td>
                                            <?= $row["SELVAN"] ?>
                                        </td>
                                        <td>
                                            <?= $row["SELVI"] ?>
                                        </td>
                                        <td>
                                            <?= $row["PLACE"] ?>
                                        </td>
                                        <td>
                                            <?= $row["MOBILE NUMBER"] ?>
                                        </td>
                                        <td>
                                            <?= $row["ITEM NAME"] ?>
                                        </td>
                                        <td>
                                            <?= $row["SIZE"] ?>
                                        </td>
                                        <td>
                                            <?= $row["MODEL"] ?>
                                        </td>
                                        <td>
                                            <?= $row["EXTRA DETAIL"] ?>
                                        </td>
                                        <td>
                                            <?= $row["HANDLE"] ?>
                                        </td>
                                        <td>
                                            <?= $row["PRINTING COLOR"] ?>
                                        </td>
                                        <td>
                                            <?= $row["SIDE PATTI COLOR"] ?>
                                        </td>
                                        <td>
                                            <?= $row["ORDER QTY"] ?>
                                        </td>
                                        <td>
                                            <?= $row["RATE"] ?>
                                        </td>
                                        <td>
                                            <?= $amount ?>
                                        </td>
                                        <td>
                                            <?= $dtpCharges ?>
                                        </td>
                                        <td>
                                            <?= $total ?>
                                        </td>
                                        <td>
                                            <?= $gstPercent ?>
                                        </td>
                                        <td>
                                            <?= $gstValue ?>
                                        </td>
                                        <td>
                                            <?= $grantTotalValue ?>
                                        </td>
                                        <td>
                                            <?= $advanceAmount ?>
                                        </td>
                                        <td>
                                            <?= $discountAmount ?>
                                        </td>
                                        <td>
                                            <?= $balanceToPayValue ?>
                                        </td>
                                        <td>
                                            <?= $finalaount ?>
                                        </td>
                                        <td>
                                            <?= $row['advancepaid'] ?>
                                        </td>
                                        <td>
                                            <?= $row['finalpaid'] ?>
                                        </td>
                                    </tr>
                                    <?php
                                    $siNo++;
                                }
                            } else {
                                echo "<td colspan='32'>No data available</td>";
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php
        include "includes/script.php";
        ?>
        <!-- JavaScript code -->
        <script>
            $(document).ready(function () {
                // Add a click event listener to the "Order Assign" buttons
                $('.order-assign').click(function () {
                    var orderId = $(this).data('order-id'); // Get the order ID from the data attribute

                    // Use orderId to populate the modal
                    $('#exampleModal').find('.ordernocolor').text('Order No: ' + orderId);


                });
            });
        </script>
        <script>
            $(document).ready(function () {
                $("#searchInput").on("keyup", function () {
                    var value = $(this).val().toLowerCase();
                    $("table tbody tr").filter(function () {
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                    });
                });
            });
        </script>


        <script>$(document).ready(function () {
                $("#dropdownlist").change(function () {
                    const selectedValue = $(this).val();
                    // Redirect to the current page with the new row-per-page value
                    window.location.href = `manage_order.php?itemsPerPage=${selectedValue}&page=1`;
                });

                // Rest of your JavaScript code
            });

            $(document).ready(function () {
                let showPending = true; // Variable to track the state

                // Function to show pending orders
                function showPendingOrders() {
                    // Hide all rows initially
                    $("table tbody tr").hide();

                    // Show rows with "pending" status
                    $("table tbody tr td:nth-child(5) button.btn-danger").closest("tr").show();
                }

                // Function to show all orders
                function showAllOrders() {
                    // Show all rows
                    $("table tbody tr").show();
                }

                // Show all orders initially
                showAllOrders();

                // Handle the click event on the toggle button
                $("#toggleOrders").click(function () {
                    if (showPending) {
                        showAllOrders();
                        $(this).text("SHOW PENDING ORDER");
                    } else {
                        showPendingOrders();
                        $(this).text("SHOW ALL ORDERS");
                    }
                    showPending = !showPending;
                });
            });
        </script>
</body>

</html>