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
    $sql = "DELETE FROM manage_tailor WHERE id = $idToDelete";

    if ($conn->query($sql) === TRUE) {
        // Record deleted successfully, show a pop-up message
        echo '<script>
            alert("Order deleted successfully.");
            window.location.href = "manage_tailor.php";
        </script>';
    } else {
        // There was an error deleting the record, show an error pop-up
        echo '<script>
            alert("Error deleting order: ' . $conn->error . '");
            window.location.href = "manage_tailor.php";
        </script>';
    }
} else {
    echo "No 'id' parameter provided in the URL.";
}
?>
