<?php
// Connect to your database (assumes you've set up your database connection)
include 'connection.php';

// Get the order number from the AJAX request
$orderNumber = $_POST['order_number'];

// Check if the order number is empty
if (empty($orderNumber)) {
    // Order number is empty, send a response
    echo 'empty';
} else {
    // Query to check if the order number exists
    $sql = "SELECT * FROM manage_order WHERE `ORDER NUMBER`  = '$orderNumber'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Order number exists, send a response
        echo 'exists';
    } else {
        // Order number doesn't exist, send a response
        echo 'not_exists';
    }
}

// Close the database connection
$conn->close();
?>