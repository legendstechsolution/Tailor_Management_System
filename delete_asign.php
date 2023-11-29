<?php
session_start();
include 'connection.php';

if (isset($_GET['assignid'])) {
    $orderno = $_GET['assignid'];
    $orderNumber = $_GET['order_number'];
    // Check if the user is not authenticated
    if (!isset($_SESSION["Name"])) {
        header("Location: login.php"); // Redirect to the login page
        exit;
    }

    // Check if the user has permission to delete records, or if the record belongs to them, or implement any other permission checks as needed.

    // Perform the deletion
    $delete_query_tailor_assign = "DELETE FROM tailor_assign WHERE id = '$orderno'";

    if ($conn->query($delete_query_tailor_assign) === TRUE) {
        // Record deleted successfully from 'tailor_assign'

        // Now, delete related records from the 'payments' table based on the order number
        $delete_query_payments = "DELETE FROM payments WHERE order_id = '$orderNumber'";

        if ($conn->query($delete_query_payments) === TRUE) {
            // Records deleted successfully from 'payments'
            header("Location: tailor_work_assign.php");
            exit;
        } else {
            echo "Error deleting records from 'payments': " . $conn->error;
        }
    } else {
        echo "Error deleting records from 'tailor_assign': " . $conn->error;
    }

    // Close the database connection
    $conn->close();
} else {
    echo "Assign ID and/or Order number not provided.";
}

?>