<?php
session_start();

// Check if the user is not authenticated
if (!isset($_SESSION["Name"])) {
    header("Location: login.php"); // Redirect to the login page
    exit; // Ensure the script exits to prevent further execution
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
            <div class="container card  mt-3">
                <div class="row">
                    <div class="col-md-4  mt-5">
                        <img src="assets/img/account.png" class="rounded d-flex justify-content-end mt-5 ms-4"
                            width="200px" />
                        <p class="jones mt-2 text-center ">Jones</p>
                        <p class="jones name d-flex justify-content-center">jonesjone009@gamil.com</p>
                    </div>
                    <div class=" col-md-8  mt-4 mb-4">

                        <h3 class="mt-5">Profile Settings</h3>


                        <div class="row ">
                            <div class="col-md-6 ">
                                <label class="form-label text-dark">Name</label>
                                <input type="text" class="form-control" placeholder="Enter a Name">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-dark">Email ID</label>
                                <input type="text" class="form-control" placeholder="Enter a Details">
                            </div>
                        </div>

                        <div class="row pt-4">
                            <div class="col-md-6">
                                <label class="form-label text-dark">Mobile Number</label>
                                <input type="text" class="form-control" placeholder="Enter a Phone Number">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-dark">Address</label>
                                <input type="text" class="form-control " placeholder="Enter a Address">
                            </div>
                        </div>

                        <div class="row pt-4 pb-4">
                            <div class="col-md-3   ">

                            </div>
                            <div class="col-md-6 d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary text ps-1 "><b>UPDATE PROFILE</b></button>
                            </div>
                            <div class="col-md-3">

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    <?php
    include "includes/script.php";
    ?>
</body>

</html>