<?php
session_start();
include 'connection.php';

// Check if the user is not authenticated

// Initialize variables to hold the form values
$_Name = '';
$_Email = '';
$_Phone_Number = '';
$_Address = '';

// Check if a tailor ID is provided in the URL (for editing)
if (isset($_GET['tailor_id'])) {
    $tailor_id = $_GET['tailor_id'];
    $query = "SELECT * FROM manage_tailor WHERE `ID` = $tailor_id";
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_Name = $row['Name'];
        $_Email = $row['Email'];
        $_Phone_Number = $row['Phone_Number'];
        $_Address = $row['Address'];
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_Name = $_POST["Name"];
    $_Email = $_POST["Email"];
    $_Phone_Number = $_POST["Phone_Number"];
    $_Address = $_POST["Address"];

    // Check if a tailor ID is provided in the URL (for editing)
    if (isset($_GET['tailor_id'])) {
        $tailor_id = $_GET['tailor_id'];
        $sql = "UPDATE manage_tailor SET `Name` = '$_Name', `Email` = '$_Email', `Phone_Number` = '$_Phone_Number', `Address` = '$_Address' WHERE `ID` = $tailor_id";
    } else {
        $sql = "INSERT INTO manage_tailor(`Name`, `Email`, `Phone_Number`, `Address`) VALUES('$_Name', '$_Email', '$_Phone_Number', '$_Address')";
    }

    if (mysqli_query($conn, $sql)) {
        echo '<script>window.location.href="manage_tailor.php"</script>';
    } else {
        echo "Error: " . mysqli_error($conn);
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
    <div class="col-md-12  scrollable-content">
        <div class="container card mt-4  mb-4">
            <h3 class="mt-4 mb-3 d-flex justify-content-center">
                <?php echo isset($_GET['tailor_id']) ? 'Edit' : 'Add'; ?> Tailor Details
            </h3>
            <form method="post">
                <div class="row mt-4 d-print-grid">
                    <div class="col-md-6">
                        <label class="form-label text-dark" style="font-size: 14px;">Name</label>
                        <input type="text" class="form-control" name="Name" placeholder="Enter a Name"
                            value="<?php echo $_Name; ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-dark" style="font-size: 14px;">Email</label>
                        <input type="text" class="form-control" name="Email" placeholder="Enter a Details"
                            value="<?php echo $_Email; ?>">
                    </div>
                </div>
                <div class="row pt-4">
                    <div class="col-md-6">
                        <label class="form-label text-dark" style="font-size: 14px;">Phone Number</label>
                        <input type="text" class="form-control" name="Phone_Number" placeholder="Enter a Phone Number"
                            value="<?php echo $_Phone_Number; ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-dark" style="font-size: 14px;">Address</label>
                        <input type="text" class="form-control" name="Address" placeholder="Enter an Address"
                            value="<?php echo $_Address; ?>">
                    </div>
                </div>
                <div class="row pt-4 pb-4">
                    <div class="col-md-3">
                    </div>
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary alpha w-100">
                            <?php echo isset($_GET['tailor_id']) ? 'Update' : 'Submit'; ?>
                        </button>
                    </div>
                    <div class="col-md-3 ">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php
    include "includes/script.php";
    ?>
</body>

</html>