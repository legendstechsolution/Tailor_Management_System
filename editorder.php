<?php

include 'connection.php';
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the existing record data
    $query = "SELECT * FROM your_table_name WHERE id = $id";
    $result = mysqli_query($connection, $query);
    $record = mysqli_fetch_assoc($result);

    if (!$record) {
        echo "Record not found.";
    }

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $newData = $_POST['new_data']; // Retrieve updated data from the form

        // Update the record in the database
        $updateQuery = "UPDATE your_table_name SET column_name = '$newData' WHERE id = $id";
        $updateResult = mysqli_query($connection, $updateQuery);

        if ($updateResult) {
            echo "Record updated successfully.";
        } else {
            echo "Error updating record: " . mysqli_error($connection);
        }
    }
} else {
    echo "No record ID provided for editing.";
}
?>

<form method="POST" action="edit.php?id=<?php echo $id; ?>">
    <label for="new_data">New Data:</label>
    <input type="text" name="new_data" value="<?php echo $record['column_name']; ?>">
    <button type="submit">Update</button>
</form>
