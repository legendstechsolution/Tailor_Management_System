<?php
session_start();
include 'connection.php';

// Check if the user is not authenticated
if (!isset($_SESSION["Name"])) {
    header("Location: login.php"); // Redirect to the login page
    exit; // Ensure the script exits to prevent further execution
}

// Initialize variables to hold form data
$name = '';
$email = '';
$phone_number = '';
$password = '';
$address = '';
$edit_id = '';
// Check if an edit ID is provided in the URL (for editing)
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $query = "SELECT * FROM manage_staff WHERE ID = $edit_id";
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $name = $row['Name'];
        $email = $row['Email'];
        $phone_number = $row['Phone_Number'];
        $password = $row['Password'];
        $address = $row['Address'];
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $password = $_POST['password'];
    $address = $_POST['address'];

    // Check and print the values
    echo "Name: " . $name . "<br>";
    echo "Email: " . $email . "<br>";
    echo "Phone Number: " . $phone_number . "<br>";
    echo "Password: " . $password . "<br>";
    echo "Address: " . $address . "<br>";

    $msg = "";

    if (empty($name) || empty($password)) {
        $msg = "Name and Password are required fields.";
    } else {
        // Check if the name and password combination already exists
        $existingNameCheckQuery = "SELECT ID FROM manage_staff WHERE `Name` = '$name'";
        $existingPasswordCheckQuery = "SELECT ID FROM manage_staff WHERE `Password` = '$password'";
        $existingNameCheckResult = mysqli_query($conn, $existingNameCheckQuery);
        $existingPasswordCheckResult = mysqli_query($conn, $existingPasswordCheckQuery);

        $msg = ""; // Initialize the error message as an empty string

        if (mysqli_num_rows($existingNameCheckResult) > 0) {
            $msg = "The name already exists. Please choose a different name.";
        } elseif (mysqli_num_rows($existingPasswordCheckResult) > 0) {
            $msg = "The password already exists. Please choose a different password.";

        } else {
            if (isset($_POST['edit_id'])) {
                // Editing mode: Update the existing record
                $edit_id = $_POST['edit_id'];
                $sql = "UPDATE manage_staff SET `Name` = '$name', `Email` = '$email', `Phone_Number` = '$phone_number', `Password` = '$password', `Address` = '$address' WHERE ID = $edit_id";


            } else {
                // Insert new data
                $sql = "INSERT INTO manage_staff (Name, Email, Phone_Number, Password, Address)
                        VALUES ('$name', '$email', '$phone_number', '$password', '$address')";

            }

            if (mysqli_query($conn, $sql)) {
                header('Location: manage_staff.php');
                exit();
            } else {
                $msg = "Error: " . mysqli_error($conn);

            }
        }
    }

}





?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include 'includes/head.php';
    ?>
</head>

<body>
    <?php
    include 'includes/header.php';
    ?>
    </div>

    <div class="col-md-12  scrollable-content">
        <div class="container card mt-3">
            <div class=" mt-4">
                <h3 class="mt-2">
                    <?php echo isset($_GET['edit_id']) ? 'Edit' : 'Add'; ?> Staff Details
                </h3>
                <?php
                // Display the error message
                if (!empty($msg)) {
                    echo '<div class="alert alert-danger">' . $msg . '</div>';
                } ?>

                <form method="post">
                    <input type="hidden" name="<?php echo isset($_GET['edit_id']) ? 'edit_id' : ''; ?>"
                        value="<?php echo isset($_GET['edit_id']) ? $_GET['edit_id'] : ''; ?>">

                    <div class="row d-print-grid">
                        <div class="col-md-6">
                            <label class="form-label mb-1 ps-1 text-dark" style="font-size: 14px;">Name</label>
                            <input type="text" conn class="form-control mb-3" name="name" placeholder="Enter a Name"
                                value="<?php echo $name; ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label mb-1 ps-1 text-dark" style="font-size: 14px;">Email</label>
                            <input type="text" class="form-control mb-3" name="email" placeholder="Enter an Email"
                                value="<?php echo $email; ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label mb-1 ps-1 text-dark" style="font-size: 14px;">Phone Number</label>
                            <input type="text" class="form-control mb-3" name="phone_number"
                                placeholder="Enter a Phone Number" value="<?php echo $phone_number; ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label mb-1 ps-1 text-dark" style="font-size: 14px;">Password</label>
                            <input type="text" conn class="form-control mb-3" name="password"
                                placeholder="Enter a Password" value="<?php echo $password; ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label mb-1 ps-1 text-dark" style="font-size: 14px;">Address</label>
                            <textarea class="form-control mb-4" name="address"
                                placeholder="Enter an Address"><?php echo $address; ?></textarea>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-3">
                        </div>
                        <div class="col-md-6 ps-1">
                            <button type="submit" class="form btn btn-primary alpha w-100 mb-4 ">
                                <?php echo isset($_GET['edit_id']) ? 'Update' : 'Submit'; ?>
                            </button>
                        </div>
                        <div class="col-md-3">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
    include 'includes/script.php';
    ?>
</body>

</html>