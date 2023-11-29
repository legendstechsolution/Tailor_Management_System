<?php
session_start();

// Check if the user is not authenticated
if (!isset($_SESSION["Name"])) {
    header("Location: login.php"); // Redirect to the login page
    exit; // Ensure the script exits to prevent further execution
}

// Include your connection.php file
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the form
    $order_no = $_POST['order_no'];
    $date = $_POST['date'];
    $tailor_id = $_POST['tailor_id'];
    $quantity = $_POST['quantity'];
    $rate = $_POST['rate'];

    // Calculate the amount
    $amount = $quantity * $rate;

    // Insert data into your tailor_assign table
    $insertAssignmentQuery = "INSERT INTO tailor_assign (order_no, tailor_id, assignment_date, quantity, rate)
    VALUES ('$order_no', '$tailor_id', '$date', '$quantity', '$rate')";




    // Execute the queries
    if ($conn->query($insertAssignmentQuery) === TRUE) {
        // Assignment and update were successful, you can redirect or display a success message
        header("Location:manage_order.php");
    } else {
        // Handle errors
        echo "Error: " . $conn->error;
    }

    $conn->close();
}


$orderno = $_GET["orderno"];

?>
<!DOCTYPE html>
<html lang="en">



<head>
    <?php include 'includes/head.php'; ?>
</head>


<body>
    <div class="container ">
        <div class="card m-4 p-4">
            <form actiom="" method="post">
                <div class="modal-content container">
                    <div class="modal-header">

                        <h5 class="modal-title" id="exampleModalLabel">Order Assign</h5>
                        <a class="btn" href="manage_order.php"> <button type="button" class="btn-close"></button>
                        </a>

                    </div>
                    <div class="modal-body">
                        <h5 class="text-center ordernocolor">Order No :
                            <?php echo $orderno; ?>
                        </h5>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="labels">
                                    <?php
                                    // Replace with the actual order number you want to retrieve the total quantity for
                                    $quantityquery = "SELECT * FROM manage_order WHERE `ORDER NUMBER` = '$orderno'";
                                    $quantityresult = $conn->query($quantityquery);

                                    if ($quantityresult && $quantityresult->num_rows > 0) {
                                        $row = $quantityresult->fetch_assoc();
                                        $totalQuantity = $row['ORDER QTY'];
                                        echo '<p class="quantitfocus">Total Qty: ' . $totalQuantity . '</p>';
                                    } else {
                                        echo '<p>No data found for the provided order number.</p>';
                                    }
                                    ?>
                                </label>
                            </div>
                            <div class="col-md-6 text-end">
                                <label class="labels">
                                    <p class="quantitfocus1">
                                        Remaining Qty:
                                        <?php
                                        // Calculate the remaining quantity based on the order quantity and assigned quantity
                                        $assignedQuantity = 0; // Initialize the assigned quantity to zero
                                        $assignmentQuery = "SELECT SUM(quantity) AS assigned_quantity FROM tailor_assign WHERE order_no = '$orderno'";
                                        $assignmentResult = $conn->query($assignmentQuery);

                                        if ($assignmentResult && $assignmentResult->num_rows > 0) {
                                            $assignedData = $assignmentResult->fetch_assoc();
                                            $assignedQuantity = $assignedData['assigned_quantity']; // Use the alias assigned_quantity
                                        }
                                        $remainingQuantity = $totalQuantity - $assignedQuantity;
                                        echo $remainingQuantity;
                                        ?>
                                    </p>

                                </label>
                            </div>
                        </div>

                        <div class="mb-3 col-6">
                            <label for="exampleFormControlInput1" class="form-label">Date</label>
                            <input type="date" class="form-control text-uppercase" name="date"
                                id="exampleFormControlInput1">
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Tailor
                                    Name</label>

                                <select class="form-select" name="tailor_id" aria-label="Default select example"
                                    id="tailor_id" oninput="checkOrderNumber()">
                                    <option selected>Select a tailor</option>

                                    <?php
                                    $tailorquery = "SELECT * FROM manage_tailor";
                                    $tailorcheck = mysqli_query($conn, $tailorquery);

                                    if (mysqli_num_rows($tailorcheck) > 0) {
                                        while ($tailorrow = mysqli_fetch_assoc($tailorcheck)) {
                                            echo '<option value="' . $tailorrow['ID'] . '">' . $tailorrow['Name'] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                                <div id="duplicateMessage"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="quantity" class="form-label">Qty</label>
                                    <input type="number" class="form-control" name="quantity" id="quantity"
                                        placeholder="Quantity" required max="<?php echo $remainingQuantity; ?>"
                                        oninput="validateQuantity()">
                                    <span id="quantityError" style="color: red;"></span>
                                </div>
                                <input type="hidden" name="order_no" value="<?php echo $orderno; ?>" id="order_number">
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="rate" class="form-label">Rate</label>
                                    <input type="number" class="form-control" name="rate" id="rate" placeholder="Rate"
                                        required oninput=calculateAmount()>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="amount" class="form-label">Amount</label>
                                    <input class="form-control" name="amount" id="amount" readonly disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a class="btn" href="manage_order.php"> <button type="button"
                                class="btn btn-secondary">Close</button>
                        </a>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php
    include "includes/script.php";
    ?>
    <script>
        function validateQuantity() {
            var quantityInput = document.getElementById("quantity");
            var maxQuantity = parseInt(quantityInput.getAttribute("max"));
            var enteredQuantity = parseInt(quantityInput.value);
            var quantityError = document.getElementById("quantityError");

            if (enteredQuantity > maxQuantity) {
                quantityInput.setCustomValidity("Quantity cannot exceed the available total quantity.");
                quantityError.textContent = "Quantity cannot exceed the available total quantity.";
            } else {
                quantityInput.setCustomValidity("");
                quantityError.textContent = "";
            }

            // After validating quantity, calculate the amount
            calculateAmount();
        }

        function calculateAmount() {
            var quantityInput = document.getElementById("quantity");
            var rateInput = document.getElementById("rate");
            var amountInput = document.getElementById("amount");

            var quantity = parseFloat(quantityInput.value) || 0;
            var rate = parseFloat(rateInput.value) || 0;
            var amount = quantity * rate;

            amountInput.value = amount.toFixed(2);
        }
        // Add an event listener to the button
        function checkOrderNumber() {
            // Get the order number and tailor ID from the input fields

            const orderNumber = document.getElementById("order_number").value;
            const tailorID = document.getElementById("tailor_id").value;

            // Create an XMLHttpRequest object
            const xhr = new XMLHttpRequest();

            // Set up the request
            xhr.open("POST", "check_duplicate.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            // Define the function to handle the response
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        // Response from the server
                        const response = xhr.responseText;

                        // Display the response message
                        const duplicateMessage = document.getElementById("duplicateMessage");
                        if (response === 'duplicate') {
                            duplicateMessage.textContent = 'This Order is already assigned to another tailor.';
                            duplicateMessage.classList.add("error");
                            duplicateMessage.classList.remove("success");
                        } else if (response === 'success') {
                            duplicateMessage.textContent = '';
                            duplicateMessage.classList.remove("error");
                        } else if (response === 'empty') {
                            duplicateMessage.textContent = '';

                        } else {
                            console.error("Invalid response from the server.");
                        }
                    } else {
                        // Handle errors
                        console.error("Request failed with status: " + xhr.status);
                    }
                }
            };

            // Send the request with the order number and tailor ID
            xhr.send("order_number=" + orderNumber + "&tailor_id=" + tailorID);
        }


    </script>

</body>

</html>