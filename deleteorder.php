<?php
session_start();

// Check if the user is not authenticated
if (!isset($_SESSION["Name"])) {
    header("Location: login.php"); // Redirect to the login page
    exit; // Ensure the script exits to prevent further execution
}
include 'connection.php';

if (isset($_GET['id'])) {
    $idToDelete = intval($_GET['id']);
    $sql = "DELETE FROM manage_order WHERE id = $idToDelete";

    if ($conn->query($sql) === TRUE) {
        // Record deleted successfully, show a pop-up message
        echo '<script>
            window.location.href = "manage_order.php";
        </script>';
    } else {
        // There was an error deleting the record, show an error pop-up
        echo '<script>
            alert("Error deleting order: ' . $conn->error . '");
        </script>';
    }
} else {
    echo "No 'id' parameter provided in the URL.";
}
?>
