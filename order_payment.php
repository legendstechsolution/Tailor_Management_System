<?php
include 'connection.php';


// SQL query to fetch payment history data (adjust the query to your database schema)
$order_id = $_GET['order_id']; // Replace with your actual order_id
$tailor_id = $_GET['tailor_id']; // Replace with your actual tailor_id

$sql = "SELECT * FROM payments WHERE order_id = '$order_id' AND tailorId = $tailor_id";

$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}

// Fetch the data and store it in an array
$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Close the database connection
$conn->close();

// Set the response content type to JSON
header("Content-Type: application/json");

// Return the data as JSON
echo json_encode($data);
