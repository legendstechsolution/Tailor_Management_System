<?php
session_start();

// Check if the user is not authenticated
if (!isset($_SESSION["Name"])) {
    header("Location: login.php"); // Redirect to the login page
    exit; // Ensure the script exits to prevent further execution
}

include 'connection.php';
$edit_id = null;
if (isset($_GET['id'])) {
    $edit_id = $_GET['id'];
    $edit_sql = "SELECT * FROM manage_order WHERE ID = $edit_id";
    $edit_result = mysqli_query($conn, $edit_sql);
    $edit_row = mysqli_fetch_assoc($edit_result);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    $order_date = $_POST['order_date'];
    $order_number = $_POST['order_number'];
    $job_card_number = $_POST['job_card_number'];
    $function_name = $_POST['function_name'];
    $function_date = $_POST['function_date'];
    $person_name = $_POST['person_name'];
    $selvan = $_POST['selvan'];
    $selvi = $_POST['selvi'];
    $place = $_POST['place'];
    $mobile_number = $_POST['mobile_number'];
    $item_name = $_POST['item_name'];
    $size = $_POST['size'];
    $model = $_POST['model'];
    $extra_detail = $_POST['extra_detail'];
    $handle = $_POST['handle'];
    $printing_color = $_POST['printing_color'];
    $side_patti_color = $_POST['side_patti_color'];
    $order_quantity = $_POST['order_quantity'];
    $rate = $_POST['rate'];
    $dtp_charges = $_POST['dtp_charges'];
    $gst = $_POST['gst'];
    $advance = $_POST['advance'];
    $discount = $_POST['discount'];
    $finalpaid = $_POST['finalpaid'];
    $advancepaid = $_POST['advancepaid'];
    $final_amount_paid = $_POST['final_amount_paid'];
    if (isset($_POST['update_id'])) {
        // UPDATE an existing record
        $update_id = $_POST['update_id'];
        $sql = "UPDATE manage_order SET 
        `ORDER DATE` = '$order_date',
        `ORDER NUMBER` = '$order_number',
        `JC NO` = '$job_card_number',
        `FUNCTION NAME` = '$function_name',
        `FUNCTION DATE` = '$function_date',
        `PERSON NAME` = '$person_name',
        `SELVAN` = '$selvan',
        `SELVI` = '$selvi',
        `PLACE` = '$place',
        `MOBILE NUMBER` = '$mobile_number',
        `ITEM NAME` = '$item_name',
        `SIZE` = '$size',
        `MODEL` = '$model',
        `EXTRA DETAIL` = '$extra_detail',
        `HANDLE` = '$handle',
        `PRINTING COLOR` = '$printing_color',
        `SIDE PATTI COLOR` = '$side_patti_color',
        `ORDER QTY` = '$order_quantity',
        `RATE` ='$rate',
        `DTP CHARGES` = '$dtp_charges',
        `GST%` = '$gst',
        `ADVANCE` = '$advance',
        `DISCOUNT` = '$discount',
        `final_amount_paid` ='$final_amount_paid',
        `advancepaid` = '$advancepaid',
        `finalpaid` = '$finalpaid'
        WHERE ID = $update_id";
        $operation = "updated";
    } else {
        // INSERT a new record
        $sql = "INSERT INTO manage_order (`ORDER DATE`, `ORDER NUMBER`, `JC NO`, `FUNCTION NAME`, `FUNCTION DATE`, `PERSON NAME`, `SELVAN`, `SELVI`, `PLACE`, `MOBILE NUMBER`, `ITEM NAME`, `SIZE`, `MODEL`, `EXTRA DETAIL`, `HANDLE`, `PRINTING COLOR`, `SIDE PATTI COLOR`, `ORDER QTY`, `RATE`, `DTP CHARGES`, `GST%`, `ADVANCE`, `DISCOUNT`,`final_amount_paid`,`advancepaid`,`finalpaid`)
        VALUES (
            '$order_date',
            '$order_number',
            '$job_card_number',
            '$function_name',
            '$function_date',
            '$person_name',
            '$selvan',
            '$selvi',
            '$place',
            '$mobile_number',
            '$item_name',
            '$size',
            '$model',
            '$extra_detail',
            '$handle',
            '$printing_color',
            '$side_patti_color',
            '$order_quantity',
            '$rate',
            '$dtp_charges',
            '$gst',
            '$advance',
            '$discount', 
            '$final_amount_paid',
            '$advancepaid',
            '$finalpaid'
        )";
        $operation = "added";

    }

    if (mysqli_query($conn, $sql)) {

        echo '<script>
        alert("order ' . $operation . ' successfully");
        window.location.href="manage_order.php";
    </script>';
    } else {
        // If there's an error in the SQL query, display the error message
        echo "Error: " . mysqli_error($conn);
    }

}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'includes/head.php'; ?>
</head>

<body>

    <?php include 'includes/header.php'; ?>
    <div id="loader-container">
        <div id="loader"></div>
    </div>


    <div class="col-md-12  scrollable-content">
        <div class="container  card   mt-4 mb-4 ">
            <h3 class="d-flex justify-content-center pt-4 pb-2">Fill The Details</h3>
            <form method="post" action="">
                <?php if ($edit_id !== null): ?>
                    <input type="hidden" name="update_id" value="<?= $edit_id; ?>">
                <?php endif; ?>
                <div class="row pt-4">
                    <div class=" container-fluid col-md-6">
                        <div class="row">
                            <div class="col-md-5">
                                <label class="form-control input_yellow  mb-1 ">Order Date</label>
                            </div>
                            <div class="col-md-7">
                                <input type="date" class="form-control input_yellow" name="order_date"
                                    value="<?= isset($edit_row['ORDER DATE']) ? $edit_row['ORDER DATE'] : '' ?>"
                                    tabindex="1">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-5">
                                <label class="form-control input_green  mb-1 ">ITEM NAME</label>
                            </div>
                            <div class="col-md-7">
                                <input type="text" class="form-control input_green" name="item_name"
                                    value="<?= isset($edit_row['ITEM NAME']) ? $edit_row['ITEM NAME'] : '' ?>"
                                    tabindex="11">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row pt-4">
                    <div class="col-md-6 container-fluid">
                        <div class="row">
                            <div class="col-md-5">
                                <label class="form-control input_yellow  mb-1 ">Order Number</label>
                            </div>
                            <div class="col-md-7">
                                <input type="text" class="form-control input_yellow" id="order_number"
                                    name="order_number"
                                    value="<?= isset($edit_row['ORDER NUMBER']) ? $edit_row['ORDER NUMBER'] : '' ?>"
                                    tabindex="2" oninput="checkOrderNumber()">
                                <span id="order_number_message"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-5">
                                <label class="form-control  input_green mb-1 ">Size</label>
                            </div>
                            <div class="col-md-7">
                                <input type="text" class="form-control input_green" name="size"
                                    value="<?= isset($edit_row['SIZE']) ? $edit_row['SIZE'] : '' ?>" tabindex="12">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row pt-4">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-5">
                                <label class="form-control input_yellow  mb-1">Job Card Number</label>
                            </div>
                            <div class="col-md-7">
                                <input type="text" name="job_card_number" class="form-control input_yellow mb-2"
                                    value="<?= isset($edit_row['JC NO']) ? $edit_row['JC NO'] : '' ?>" tabindex="3">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-5">
                                <label class="form-control input_green  mb-1">MODEL</label>
                            </div>
                            <div class="col-md-7">
                                <input type="text" class="form-control input_green mb-2" name="model"
                                    value="<?= isset($edit_row['MODEL']) ? $edit_row['MODEL'] : '' ?>" tabindex="13">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row pt-4">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-5">
                                <label class="form-control input_yellow  mb-1 ">FUNCTION NAME</label>
                            </div>
                            <div class="col-md-7">
                                <input type="text" class="form-control input_yellow mb-2" name="function_name"
                                    value="<?= isset($edit_row['EXTRA DETAIL']) ? $edit_row['EXTRA DETAIL'] : '' ?>"
                                    tabindex="4">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-5">
                                <label class="form-control input_green  mb-1">EXTRA DETAIL</label>
                            </div>
                            <div class="col-md-7">
                                <input type="text" class="form-control input_green " name="extra_detail"
                                    value="<?= isset($edit_row['EXTRA DETAIL']) ? $edit_row['EXTRA DETAIL'] : '' ?>"
                                    tabindex="14">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row pt-4">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-5">
                                <label class="form-control input_yellow  mb-1 ">FUNCTION DATE</label>
                            </div>
                            <div class="col-md-7">
                                <input type="date" class="form-control input_yellow mb-2" name="function_date"
                                    value="<?= isset($edit_row['FUNCTION DATE']) ? $edit_row['FUNCTION DATE'] : '' ?>"
                                    tabindex="5">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-5">
                                <label class="form-control input_green  mb-1">HANDLE</label>
                            </div>
                            <div class="col-md-7">
                                <input type="text" class="form-control input_green" name="handle"
                                    value="<?= isset($edit_row['HANDLE']) ? $edit_row['HANDLE'] : '' ?>" tabindex="15">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row pt-4">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-5">
                                <label class="form-control input_yellow  mb-1">PERSON NAME</label>
                            </div>
                            <div class="col-md-7">
                                <input type="text" class="form-control input_yellow mb-2" name="person_name"
                                    value="<?= isset($edit_row['PERSON NAME']) ? $edit_row['PERSON NAME'] : '' ?>"
                                    tabindex="6">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-5">
                                <label class="form-control input_green  mb-1">PRINTING COLOR</label>
                            </div>
                            <div class="col-md-7">
                                <input type="text" class="form-control input_green" name="printing_color"
                                    value="<?= isset($edit_row['PRINTING COLOR']) ? $edit_row['PRINTING COLOR'] : '' ?>"
                                    tabindex="16">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row pt-4">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-5">
                                <label class="form-control input_yellow  mb-1">SELVAN</label>
                            </div>
                            <div class="col-md-7">
                                <input type="text" class="form-control input_yellow mb-2" name="selvan"
                                    value="<?= isset($edit_row['SELVAN']) ? $edit_row['SELVAN'] : '' ?>" tabindex="7">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-5">
                                <label class="form-control input_green  mb-1">SIDE PATTI COLOR</label>
                            </div>
                            <div class="col-md-7">
                                <input type="text" class="form-control input_green" name="side_patti_color"
                                    value="<?= isset($edit_row['SIDE PATTI COLOR']) ? $edit_row['SIDE PATTI COLOR'] : '' ?>"
                                    tabindex="17">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row pt-4">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-5">
                                <label class="form-control input_yellow  mb-1">SELVI</label>
                            </div>
                            <div class="col-md-7">
                                <input type="text" class="form-control input_yellow" name="selvi"
                                    value="<?= isset($edit_row['SELVI']) ? $edit_row['SELVI'] : '' ?>" tabindex="8">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row pt-4">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-5">
                                <label class="form-control input_yellow  mb-1">PLACE</label>
                            </div>
                            <div class="col-md-7">
                                <input type="text" class="form-control input_yellow" name="place"
                                    value="<?= isset($edit_row['PLACE']) ? $edit_row['PLACE'] : '' ?>" tabindex="9">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row pt-4">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-5">
                                <label class="form-control input_yellow  mb-1">MOBILE NUMBER</label>
                            </div>
                            <div class="col-md-7">
                                <input type="text" class="form-control input_yellow" name="mobile_number"
                                    value="<?= isset($edit_row['MOBILE NUMBER']) ? $edit_row['MOBILE NUMBER'] : '' ?>"
                                    tabindex="10">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row pt-4">
                    <div class="col-md-3">
                        <label class="form-label calculate_input"> QUANTITY</label>
                        <input type="text" class="form-control input_yellow mb-2" name="order_quantity"
                            id="order_quantity"
                            value="<?= isset($edit_row['ORDER QTY']) ? $edit_row['ORDER QTY'] : '' ?>" tabindex="18"
                            required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label calculate_input">RATE</label>
                        <input type="text" class="form-control input_yellow mb-2" name="rate" id="rate"
                            value="<?= isset($edit_row['RATE']) ? $edit_row['RATE'] : '' ?>" tabindex="19" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label calculate_input">AMOUNT</label>
                        <input type="text" class="form-control readonly_input mb-2" name="amount" id="amount"
                            value="<?= isset($edit_row) ? $edit_row['RATE'] * $edit_row['ORDER QTY'] : '' ?>" disabled
                            readonly>
                    </div>
                </div>
                <div class="row pt-4  ps-2">
                    <div class="col-md-3">
                    </div>
                    <div class="col-md-3">
                        <label class="form-control border-0 calculate_input">DTP CHARGES</label>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control input_yellow text-end" name="dtp_charges"
                            id="dtp_charges"
                            value="<?= isset($edit_row['DTP CHARGES']) ? $edit_row['DTP CHARGES'] : '' ?>"
                            tabindex="20">
                    </div>
                    <div class="col-md-3">
                    </div>
                </div>
                <div class="row pt-4  ps-2">
                    <div class="col-md-3">

                    </div>

                    <div class="col-md-3">
                        <label class="form-control  border-0 readonly_input text-light   ">TOTAL</label>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control readonly_input" name="total" id="total" disabled
                            value="<?= isset($edit_row) ? ($edit_row['RATE'] * $edit_row['ORDER QTY']) : '' ?>"
                            readonly>
                    </div>

                    <div class="col-md-3">
                    </div>
                </div>
                <div class="row pt-4  ps-2">
                    <div class="col-md-3">
                    </div>

                    <div class="col-md-3">
                        <label class="form-control  border-0 calculate_input  ">GST%</label>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control input_yellow  text-end" name="gst" id="gst_percent"
                            value="<?= isset($edit_row['GST%']) ? $edit_row['GST%'] : '' ?>" tabindex="21">
                    </div>

                    <div class="col-md-3">
                    </div>
                </div>
                <div class="row pt-4  ps-2">
                    <div class="col-md-3">

                    </div>

                    <div class="col-md-3">
                        <label class="form-control  readonly_input text-white  border-0 ">GST VALUE</label>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control readonly_input   " name="gst_value" id="gst_value"
                            disabled readonly>
                    </div>

                    <div class="col-md-3">
                    </div>
                </div>
                <div class="row pt-4 ps-2">
                    <div class="col-md-3">

                    </div>
                    <div class="col-md-3">
                        <label class="form-control calculate_input  border-0">DISCOUNT</label>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control input_yellow text-end " name="discount" id="discount"
                            value="<?= isset($edit_row['DISCOUNT']) ? $edit_row['DISCOUNT'] : '' ?>" tabindex="22">
                    </div>

                    <div class="col-md-3">
                    </div>
                </div>
                <div class="row pt-4  ps-2">
                    <div class="col-md-3">
                    </div>
                    <div class="col-md-3">
                        <label class="form-control  readonly_input text-white  ">GRANT TOTAL</label>
                    </div>

                    <div class="col-md-3">
                        <input type="text" class="form-control readonly_input   " name="grant_total" id="grant_total"
                            disabled readonly>
                    </div>

                    <div class="col-md-3">
                    </div>
                </div>
                <div class="row pt-4 ps-2">
                    <div class="col-md-3">

                    </div>

                    <div class="col-md-3 mt-1">
                        <label class="form-control calculate_input border-0 ">ADVANCE</label>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control input_yellow  text-end" name="advance" id="advance"
                            value="<?= isset($edit_row['ADVANCE']) ? $edit_row['ADVANCE'] : '' ?>" tabindex="23">
                    </div>

                    <div class="col-md-3">
                        <input type="text" placeholder="Payment Method" class="form-control input_yellow "
                            name="advancepaid"
                            value="<?= isset($edit_row['advancepaid']) ? $edit_row['advancepaid'] : '' ?>"
                            tabindex="24">

                    </div>

                </div>

                <div class="row pt-4  ps-2">
                    <div class="col-md-3">

                    </div>

                    <div class="col-md-3">
                        <label class="form-control  readonly_input text-white me-4 border-0 ">BALANCE TO PAY</label>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control readonly_input" name="balance_to_pay" id="balance_to_pay"
                            readonly disabled>
                    </div>

                    <div class="col-md-3">
                    </div>
                </div>


                <div class="row pt-4  ps-2">
                    <div class="col-md-3">

                    </div>

                    <div class="col-md-3 mt-1">
                        <label class="form-control readonly_input   border-0">FINAL AMOUNT PAID</label>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control input_yellow   text-end" name="final_amount_paid"
                            id="final_amount_paid"
                            value="<?= isset($edit_row['final_amount_paid']) ? $edit_row['final_amount_paid'] : '' ?>"
                            tabindex="25">
                    </div>
                    <div class="col-md-3">
                        <input type="text" placeholder="Payment Method" class="form-control input_yellow "
                            name="finalpaid" id="final_amount_paid"
                            value="<?= isset($edit_row['finalpaid']) ? $edit_row['finalpaid'] : '' ?>" tabindex="26">


                    </div>
                </div>
                <div class="row pt-4">
                    <div class="col-md-3">

                    </div>
                    <div class="col-md-6">
                        <button type="submit" class="form btn btn-primary alpha w-100 mb-3 "
                            tabindex="27">SUBMIT</button>
                    </div>
                    <div class="col-md-3">

                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php
    include "includes/script.php";
    ?>
    <script>function checkOrderNumber() {
            const orderNumber = document.getElementById('order_number').value;
            const messageElement = document.getElementById('order_number_message');

            // Perform AJAX request to the server
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'validate_order.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    const response = xhr.responseText;
                    if (response === 'exists') {
                        messageElement.textContent = 'already taken this order number';
                        messageElement.classList.add('error'); // Add the "success" class for green text.
                        messageElement.classList.remove('success'); // Remove the "error" class, if present.
                    } else if (response === 'not_exists') {
                        messageElement.textContent = '';
                        messageElement.classList.remove('error');
                    } else if (response === 'empty') {
                        messageElement.textContent = '';
                    }
                }
            };
            xhr.send('order_number=' + orderNumber);
        }
    </script>
    <script>
        document.addEventListener('keydown', function (event) {
            if (event.key === 'Enter' || event.keyCode === 13) {
                // Get the currently focused element
                const currentElement = document.activeElement;

                // Get all input and select elements in the form
                const inputElements = document.querySelectorAll('input, select');

                // Find the current element's tabindex
                const currentTabIndex = parseInt(currentElement.getAttribute('tabindex'));

                if (!isNaN(currentTabIndex)) {
                    // Find the next element with a tabindex greater than or equal to the current tabindex + 1
                    const nextElement = [...inputElements].find((element) => {
                        const elementTabIndex = parseInt(element.getAttribute('tabindex'));
                        return !isNaN(elementTabIndex) && elementTabIndex === currentTabIndex + 1;
                    });
                    console.log(nextElement);
                    if (nextElement) {
                        // Focus on the next input element
                        nextElement.focus();
                    } else {
                        // If no element with tabindex of currentTabIndex + 1 is found, focus on the first input element with tabindex 1
                        const firstElement = [...inputElements].find((element) => {
                            const elementTabIndex = parseInt(element.getAttribute('tabindex'));
                            return !isNaN(elementTabIndex) && elementTabIndex === 1;
                        });
                        if (firstElement) {
                            firstElement.focus();
                        }
                    }

                    event.preventDefault(); // Prevent the default behavior of the "Enter" key (submitting the form)
                }
            }
        });
    </script>


</body>

</html>