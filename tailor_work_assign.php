<?php
session_start();

// Check if the user is not authenticated
if (!isset($_SESSION["Name"])) {
    header("Location: login.php"); // Redirect to the login page
    exit; // Ensure the script exits to prevent further execution
}
include 'connection.php';

// Step 1: Store filter parameters
$selectValue = isset($_POST["selectValue"]) ? $_POST["selectValue"] : '';
$fromdate = isset($_POST["fromdate"]) ? $_POST["fromdate"] : '';
$todate = isset($_POST["todate"]) ? $_POST["todate"] : '';

// Step 2: Calculate the total number of records based on the filter criteria
$countQuery = "SELECT COUNT(*) AS total FROM manage_order INNER JOIN tailor_assign ON manage_order.`ORDER NUMBER` = tailor_assign.order_no";
$countQuery .= " WHERE 1"; // This will allow you to add additional conditions below

if (!empty($selectValue)) {
    $countQuery .= " AND tailor_assign.tailor_id = '$selectValue'";
}

if (!empty($fromdate)) {
    $countQuery .= " AND tailor_assign.created_date >= '$fromdate'";
}

if (!empty($todate)) {
    $countQuery .= " AND tailor_assign.created_date <= '$todate'";
}

$totalResult = $conn->query($countQuery);
$totalRow = $totalResult->fetch_assoc();
$totalRecords = $totalRow['total'];

// Step 3: Determine records per page
$recordsPerPage = (isset($_POST['recordsPerPage']) ? intval($_POST['recordsPerPage']) : (isset($_GET["recordsPerPage"]) ? intval($_GET["recordsPerPage"]) : 10));
// Step 4: Calculate total pages
$totalPages = ceil($totalRecords / $recordsPerPage);

// Step 5: Get the current page from the URL
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $recordsPerPage;
$selectQuery = "SELECT manage_order.*, tailor_assign.assignment_date, tailor_assign.tailor_id, tailor_assign.created_date, tailor_assign.rate, tailor_assign.quantity, tailor_assign.id, (SELECT SUM(amount) FROM payments WHERE order_id = manage_order.`ORDER NUMBER` AND tailorId = tailor_assign.tailor_id) AS total_paid FROM manage_order INNER JOIN tailor_assign ON manage_order.`ORDER NUMBER` = tailor_assign.order_no WHERE 1";

if (!empty($selectValue)) {
    $selectQuery .= " AND tailor_assign.tailor_id = '$selectValue'";
}

if (!empty($fromdate)) {
    $selectQuery .= " AND tailor_assign.created_date >= '$fromdate'";
}

if (!empty($todate)) {
    $selectQuery .= " AND tailor_assign.created_date <= '$todate'";
}

$selectQuery .= " ORDER BY tailor_assign.created_date DESC LIMIT $offset, $recordsPerPage";

// Execute the main SQL query
$result = $conn->query($selectQuery);


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["payment"])) {
    $tailorId = $_POST['tailorId'];
    $order_id = $_POST['order_id'];
    $payment_date = $_POST['payment_date'];
    $amount = $_POST['amount'];
    $paymentmode = $_POST['paymentmode'];

    // Perform data validation and sanitization as needed

    // Build the SQL query with the user-provided data
    $insertSql = "INSERT INTO payments (tailorId, order_id, payment_date, amount, paymentmode) VALUES (
        $tailorId,
        '$order_id',
        '$payment_date',
        $amount,
        '$paymentmode'
    )";

    // Execute the query
    if ($conn->query($insertSql) === TRUE) {
        // Insert operation was successful
        echo "<script language='javascript'>alert('Payment inserted successfully.')</script>";
        echo "<script>document.location='tailor_work_assign.php';</script>";
    } else {
        // Insert operation encountered an error
        echo "Error: " . $insertSql . "<br>" . $conn->error;
    }

}

$tailoridfilter = "SELECT * FROM manage_tailor";
$tailoridfilterresuslt = mysqli_query($conn, $tailoridfilter);


// Generate JavaScript code to set an alert message in a variable

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


    <div class="col-md-12  scrollable-content  overflow-auto" style="height:582px">

        <div class="container card mt-3 mb-3 ">

            <div class="row">
                <div class="col-md-5 ">
                    <p class="pt-2 pb-2">Tailor Production Report</p>
                </div>
                <div class="col-md-7 d-flex justify-content-end">

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
                                        echo '<li class="page-item"><a class="page-link" href="tailor_work_assign.php?page=' . ($page - 1) . '&recordsPerPage=' . $recordsPerPage . '">Previous</a></li>';
                                    }

                                    for ($i = 1; $i <= $totalPages; $i++) {
                                        echo '<li class="page-item';
                                        if ($i === $page) {
                                            echo ' active';
                                        }
                                        echo '"><a class="page-link" href="tailor_work_assign.php?page=' . $i . '&recordsPerPage=' . $recordsPerPage . '">' . $i . '</a></li>';
                                    }

                                    if ($page < $totalPages) {
                                        echo '<li class="page-item"><a class="page-link" href="tailor_work_assign.php?page=' . ($page + 1) . '&recordsPerPage=' . $recordsPerPage . '">Next</a></li>';
                                    }
                                    ?>

                                </ul>
                            </nav>
                        </div>
                    </div>


                </div>
            </div>
            <div class="">
                <form id="filterForm" action="" method="POST">
                    <hr style="border: 1px solid black;">
                    <div class="row mb-3">
                        <div class="col-md-2 col-sm-4 ">
                            <input type="text" class="form-control" placeholder="Search" id="searchInput">
                        </div>
                        <div class="col-md-2 col-sm-4">
                            <?php
                            if ($tailoridfilterresuslt) {
                                echo '<select class="form-select" aria-label="Default select example" name="selectValue">';
                                echo '<option selected value="">Select Tailor</option>';

                                // Fetch and populate the select options
                                while ($row = mysqli_fetch_assoc($tailoridfilterresuslt)) {
                                    $tailorID = $row['ID'];
                                    $tailorName = $row['Name'];
                                    echo "<option value='$tailorID'>$tailorName</option>";
                                }

                                echo '</select>';
                            } else {
                                echo "Error: " . mysqli_error($conn);
                            } ?>
                        </div>
                        <div class="col-md-3 col-sm-4">
                            <div class="input-group">
                                <label class="input-group-text">From :</label>
                                <input type="date" class="form-control" name="fromdate">
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-4">
                            <div class="input-group">
                                <label class="input-group-text">To :</label>
                                <input type="date" class="form-control" name="todate">
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-2 d-flex flex-md-nowrap">
                            <button type="submit" class="btn p-1 btn-primary profile-button ">Submit</button>
                            <button type="submit" name="clear"
                                class="btn btn-secondary close_button p-1 ms-1">CLEAR</button>
                        </div>


                    </div>
                </form>
            </div>



            <div class=" fixTableHead mb-3 ">

                <div class="table-responsive text-center">
                    <table class="table table-bordered ">
                        <thead class="table-secondary">
                            <tr class="thead-dark">
                                <th scope="col">SI.NO</th>
                                <th scope="col">DELETE</th>
                                <th scope="col">EDIT</th>
                                <th scope="col">ORDERNO</th>
                                <th scope="col">ASSIGNED</th>
                                <th scope="col">PRODUCTION DATE</th>
                                <th scope="col">SELVAN/SELVI</th>
                                <th scope="col">FUNCTION</th>
                                <th scope="col">ITEM NAME</th>
                                <th scope="col">SIZE</th>
                                <th scope="col">MODEL</th>
                                <th scope="col">EXTRA DETAIL</th>
                                <th scope="col">QTY</th>
                                <th scope="col">RATE</th>
                                <th scope="col">TOTAL AMOUNT</th>
                                <th scope="col">PAID AMOUNT</th>
                                <th scope="col">BALANCE TO PAY</th>
                                <th scope="col">ADD PAYMENT </th>
                                <th scope="col">PAYMENT HISTORY</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $totalQuantity = 0;
                            $totalRate = 0;
                            $totalAmount = 0;
                            $totalPaidAmount = 0;
                            $totalBalanceToPay = 0;
                            if (!$result) {
                                // Print the error for debugging
                                echo "Error: " . $conn->error;
                            } else {
                                // Proceed with fetching data
                                if ($result->num_rows > 0) {
                                    $counter = 1;
                                    while ($row = $result->fetch_assoc()) {
                                        $total = $row['quantity'] * $row['rate'];
                                        $balanceToPay = $total - $row['total_paid'];
                                        $totalQuantity += $row['quantity'];
                                        $totalRate += $row['rate'];
                                        $totalAmount += $row['quantity'] * $row['rate'];

                                        $totalPaidAmount += $row['total_paid'];
                                        $balanceToPay = $row['quantity'] * $row['rate'] - $row['total_paid'];
                                        $totalBalanceToPay += $balanceToPay;
                                        ?>
                                        <tr>
                                            <th scope="row ">
                                                <?= $counter ?>
                                            </th>
                                            <td>
                                                <a href="delete_asign.php?assignid=<?= $row['id'] ?>&order_number=<?= $row['ORDER NUMBER'] ?>"
                                                    class="delete-link"
                                                    onclick="return confirm('Are you sure you want to delete this record?');">
                                                    <i class="fa fa-trash-o"></i>
                                                </a>

                                            </td>
                                            <td>

                                                <a
                                                    href="editassignmodel.php?orderID=<?= $row['ORDER NUMBER'] ?>&tailorID=<?= $row['tailor_id'] ?>&action=edit">
                                                    <i class="fa fa-edit ms-2"></i>
                                                </a>


                                            </td>

                                            <td>
                                                <?= $row['ORDER NUMBER'] ?>
                                            </td>
                                            <td>
                                                <?php
                                                // Fetch the tailor name based on the tailor_id
                                                $tailorId = $row['tailor_id'];
                                                $tailorQuery = "SELECT Name FROM manage_tailor WHERE ID = $tailorId";
                                                $tailorResult = $conn->query($tailorQuery);

                                                if ($tailorResult && $tailorResult->num_rows > 0) {
                                                    $tailorData = $tailorResult->fetch_assoc();
                                                    echo $tailorData['Name'];
                                                } else {
                                                    echo "Tailor not found";
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?= date("d/m/Y", strtotime($row['assignment_date'])) ?>

                                            </td>
                                            <td>
                                                <?= $row['SELVAN'] ?>/
                                                <?= $row['SELVI'] ?>
                                            </td>
                                            <td>
                                                <?= $row['FUNCTION NAME'] ?>
                                            </td>
                                            <td>
                                                <?= $row['ITEM NAME'] ?>
                                            </td>
                                            <td>
                                                <?= $row['SIZE'] ?>
                                            </td>
                                            <td>
                                                <?= $row['MODEL'] ?>
                                            </td>
                                            <td>
                                                <?= $row['EXTRA DETAIL'] ?>
                                            </td>

                                            <td>
                                                <?= $row['quantity'] ?>
                                            </td>
                                            <td>
                                                <?= $row['rate'] ?>
                                            </td>
                                            <td>
                                                <?= $row['quantity'] * $row['rate'] ?>
                                            </td>
                                            <td>
                                                <?= $row['total_paid'] ?>
                                            </td>
                                            <td>
                                                <?= $balanceToPay ?>
                                            </td>
                                            <td>
                                                <!-- Button trigger modal -->
                                                <button type="button" class="paymentassign_id " data-tailorid="<?= $tailorId ?>"
                                                    data-orderid="<?= $row['ORDER NUMBER'] ?>">
                                                    <i class="fa fa-plus-square order-assign cursor-pointer" aria-hidden="true"></i>

                                                </button>


                                                <div class="modal fade mt-4" id="exampleModal" tabindex="-1"
                                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="container modal-dialog">
                                                        <form action="" method="post">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Add
                                                                        Payment
                                                                    </h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>

                                                                <div class="modal-body">

                                                                    <!-- Specify the PHP script for form submission -->
                                                                    <div class="modal-body">
                                                                        <h5 class="text-center ordernocolor">Order No:
                                                                            <span id="orderNoDisplay"></span>
                                                                        </h5>
                                                                        <!-- Rest of your modal content -->
                                                                    </div>

                                                                    <input type="hidden" name="tailorId" id="tailorIdInput"
                                                                        class="form-control mb-3">
                                                                    <input type="hidden" name="order_id" id="order_idInput"
                                                                        class="form-control mb-3">

                                                                    <label for="date"
                                                                        class="d-flex justify-content-start form-label">Date</label>
                                                                    <input type="date" name="payment_date" id="payment_date"
                                                                        class="form-control mb-3">
                                                                    <label for="amount"
                                                                        class="d-flex justify-content-start form-label">Amount</label>
                                                                    <input type="text" name="amount" id="amount"
                                                                        class="form-control mb-3">
                                                                    <label for="paymentmode"
                                                                        class="d-flex justify-content-start form-label">Payment
                                                                        Mode</label>
                                                                    <input type="text" name="paymentmode" id="paymentmode"
                                                                        class="form-control mb-3">

                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary close_button"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                    <button type="submit" name="payment"
                                                                        class="btn btn-primary profile-button"
                                                                        id="submitPayment">Submit</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>


                                            </td>
                                            <td>
                                                <!-- Button trigger modal -->
                                                <i class="fa fa-eye order-assign cursor-pointer open-payment-modal"
                                                    data-bs-toggle="modal" data-bs-target="#exampleModal1"
                                                    data-order-id="<?= $row['ORDER NUMBER'] ?>"
                                                    data-tailor-id="<?= $row['tailor_id'] ?>" aria-hidden="true">
                                                </i>

                                                <!-- Modal -->
                                                <div class="modal fade mt-4" id="exampleModal1" tabindex="-1"
                                                    aria-labelledby="exampleModalLabel1" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel1">Payment
                                                                    History</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                    aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="table-responsive">
                                                                    <table class="table table-bordered">
                                                                        <thead class="table-secondary">
                                                                            <tr>
                                                                                <th>SI NO</th>
                                                                                <th>AMOUNT</th>
                                                                                <th>MODE</th>
                                                                                <th>DATE</th>
                                                                                <!-- <th>EDIT</th> -->
                                                                                <th>DELETE</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>

                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <?php
                                        $counter++;
                                    }
                                }
                            }
                            ?>









                        </tbody>
                    </table>
                </div>
            </div>
            <div class=" border mt-3 p-2 bg-primary d-flex justify-content-center">
                <p><b>TOTAL EARNED:</b>
                    <?= $totalAmount ?>
                </p>
            </div>
            <div class="border p-2  bg-danger mt-1 d-flex justify-content-center">
                <p><b>LESS ADVANCE PAID (-):</b>
                    <?= $totalPaidAmount ?>
                </p>
            </div>
            <div class="border p-2  bg-warning mt-1 d-flex justify-content-center">
                <p><b>BALANCE TO PAY:</b>
                    <?= $totalBalanceToPay ?>
                </p>
            </div>
            <div class="border p-2  mb-3 bg-info mt-1 d-flex justify-content-center">
                <p><b>TOTAL QTY STRECHED:</b>
                    <?= $totalQuantity ?>
                </p>
            </div>


        </div>
    </div>

    <?php
    include "includes/script.php";
    ?>
    <script>
        $(document).ready(function () {
            // Listen for button click
            $('.paymentassign_id').click(function () {
                // Get the tailorId and order_id from data attributes
                var tailorId = $(this).data('tailorid');
                var order_id = $(this).data('orderid');
                // Update the modal with the tailorId and order_id
                $('#exampleModal').modal('show'); // Open the modal
                $('#tailorIdInput').val(
                    tailorId
                ); // Assuming you have an input element for tailorId with the id 'tailorIdInput'
                $('#order_idInput').val(
                    order_id
                ); // Assuming you have an input element for order_id with the id 'order_idInput'
                $('#orderNoDisplay').text(order_id);

            });
            $(".open-payment-modal").on("click", function () {
                var orderId = $(this).data("order-id");
                var tailorId = $(this).data("tailor-id");
                var modalTable = $('#exampleModal1').find('table tbody');
                modalTable.empty(); // Clear the table before loading new data

                $.ajax({
                    type: "GET",
                    url: "order_payment.php", // Replace with the actual URL
                    data: { order_id: orderId, tailor_id: tailorId },
                    success: function (data) {
                        data.forEach(function (item, index) {
                            var originalDate = new Date(item.createddate);
                            var formattedDate = originalDate.toLocaleDateString('en-GB', { day: '2-digit', month: '2-digit', year: 'numeric' });

                            var newRow = '<tr>' +
                                '<td>' + (index + 1) + '</td>' +
                                '<td>' + item.amount + '</td>' +
                                '<td>' + item.paymentmode + '</td>' +
                                '<td>' + formattedDate + '</td>' + // Use the formatted date
                                '<td><i class="fa fa-trash delete-record" data-record-id="' + item.payment_id + '"></i></td>' +
                                // '<td><i class="fa fa-edit edit-record" data-record-id="' + item.payment_id + '"></i></td>' +
                                '</tr>';
                            modalTable.append(newRow);
                        });

                        modalTable.find('.delete-record').on('click', function () {
                            var recordId = $(this).data('record-id');
                            if (confirm('Are you sure you want to delete this record?')) {
                                // Perform the delete action
                                deleteRecord(recordId);
                            }
                        });


                    },
                    error: function (error) {
                        console.log('Error: ' + error);
                    }

                });
            });

        });
    </script>

    <script type="text/javascript">

        function deleteRecord(recordId) {
            var modalTable = $('#exampleModal1').find('table tbody');

            // Send an AJAX request to the server to delete the record with the specified ID
            $.ajax({
                type: 'POST',
                url: 'deletepayment.php', // Update with the correct URL
                data: {
                    payment_id: recordId
                },
                success: function (response) {
                    if (response === 'success') {
                        // Handle success, for example, remove the row from the table
                        modalTable.find('.delete-record[data-record-id="' + recordId + '"]').closest('tr').remove();
                        document.location = 'tailor_work_assign.php';
                    } else {
                        alert('Error deleting the record.');
                    }
                },
                error: function () {
                    alert('Error deleting the record.');
                }
            });
        }

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

</body>

</html>