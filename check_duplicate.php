<?php
// Connect to your database (assumes you've set up your database connection)
include 'connection.php';

// Get the order number and tailor ID from the form
$orderNumber = $_POST['order_number'];
$tailorID = $_POST['tailor_id'];
if (empty($orderNumber)) {
    // Order number is empty, send a response
    echo 'empty';
} else {
    $checkDuplicateQuery = "SELECT * FROM tailor_assign WHERE order_no = '$orderNumber' AND tailor_id = '$tailorID'";
    $duplicateResult = $conn->query($checkDuplicateQuery);

    if ($duplicateResult->num_rows > 0) {
        // Duplicate records exist, handle the situation (e.g., show an error message or prevent insertion).
        echo 'duplicate';
    } else {
        // No duplicate records found, you can proceed to insert the new record.
        // Insert your new record into the database.
        // ...

        // Provide a success message or response.
        echo 'success';
    }
}
// Check for duplicate records with the same order number and tailor ID


// Close the database connection
$conn->close();
?>