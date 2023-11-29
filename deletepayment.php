<?php
// Include your connection and authentication checks
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['payment_id'])) {
    $payment_id = $_POST['payment_id'];

    // Implement necessary authentication and authorization checks before deleting

    // Perform the deletion
    $delete_query = "DELETE FROM payments WHERE payment_id  = '$payment_id '"; // Update with your table and identifier

    if ($conn->query($delete_query) === TRUE) {
        // Record deleted successfully
        echo 'success';
    } else {
        echo 'error';
    }
}

$conn->close();
?>