<!DOCTYPE html>
<html>

<head>
<?php 
include 'includes/head.php';
    ?>       
    
</head>

<body>

    <?php
    session_start();

    include 'connection.php'; // Include your database connection file

    $usernameErr = $passwordErr = '';

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $entered_email = $_POST["username"];
        $entered_password = $_POST["password"];

        if (empty($entered_email)) {
            $usernameErr = "Username is required";
            echo '<script>hideError();</script>';
        } else {
            $sql = "SELECT * FROM manage_staff WHERE Name = '$entered_email'";
            $result = mysqli_query($conn, $sql);

            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $stored_password = $row["Password"]; // Replace 'password' with the actual column name

                // Verify the entered password with the stored password
                if ($entered_password === $stored_password) {
                    // User is authenticated
                    $_SESSION["Name"] = $entered_email;
                    header("Location: index.php"); // Redirect to a welcome page after successful login
                    exit;
                } else {
                    $passwordErr = "Invalid password. Please try again.";
                    echo '<script>hideError();</script>';
                }
            } else {
                $usernameErr = "Invalid username. Please try again.";
                echo '<script>hideError();</script>';
            }
        }

        // Close the database connection
        mysqli_close($conn);
    }
    ?>

    <div class="container">
        <div class="row justify-content-center align-items-center" style="min-height: 100vh;">
            <div class="card col-lg-4 col-md-8 col-sm-10  shadow p-3 mb-5 bg-body rounded">
                <div class="card-body">
                    <h1 class="text-center">Login</h1>
                    <hr>
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Username</label>
                            <input type="text" class="form-control" name="username" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter a Username....">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" placeholder="Enter a Password...." id="exampleInputPassword1">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Submit</button>
                    </form>
                    <div class="position-fixed top-0 end-0 p-3" style="z-index: 5">
                        <?php if (!empty($usernameErr) || !empty($passwordErr)) : ?>
                            <div id="errorToast" class="toast show" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
                                <div class="toast-header bg-danger text-white">
                                    <strong class="me-auto">Error</strong>
                                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                                </div>
                                <div class="toast-body bg-danger text-white">
                                    <?php
                                    if (!empty($usernameErr)) {
                                        echo $usernameErr;
                                    }
                                    if (!empty($usernameErr) && !empty($passwordErr)) {
                                        echo '<br>';
                                    }
                                    if (!empty($passwordErr)) {
                                        echo $passwordErr;
                                    }
                                    ?>
                                </div>
                            </div>
                        <?php endif; ?>


                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php 
     include "includes/script.php" ;
      ?>
</body>

</html>
