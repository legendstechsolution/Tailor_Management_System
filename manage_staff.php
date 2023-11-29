<?php

session_start();

// Check if the user is not authenticated
if (!isset($_SESSION["Name"])) {
  header("Location: login.php"); // Redirect to the login page
  exit; // Ensure the script exits to prevent further execution
}

include 'connection.php';
$sql = "SELECT * FROM manage_staff";

$result = $conn->query($sql);

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  include 'includes/head.php';
  ?>
  <link rel="stylesheet" href="assets/css/style.css" />

</head>

<body>

  <?php
  include 'includes/header.php';
  ?>
  </div>

  <div class="col-md-12  scrollable-content">
    <div class="container  card mt-3  mt-2">
      <div class="mt-3">
        <P class="mt-3 ">Manage Staff</P>
        <hr style="border: 1px solid black;">
        <div class="row mb-3">
          <div class="col-md-8 ">
            <input type="text" placeholder="Search" class="w-100 form-control" id="searchInput" />
          </div>
          <div class="col-md-4 text-end">
            <a href="add_staff.php" class="btn btn-primary mt-1 order">CREATE STAFF</a>
          </div>
        </div>
        <div class="table-responsive  ">
          <table class="table  table-bordered text-center ">
            <thead class="table-secondary">
              <tr>
                <th scope="col">SI.NO</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Phone number</th>
                <th scope="col">Password</th>
                <th scope="col">Address</th>
                <th scope="col">Edit</th>
                <th scope="col">Delete</th>
              </tr>
            </thead>
            <tbody class="">
              <?php
              $siNo = 1;
              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td>" . $siNo . "</td>";
                  echo "<td>" . $row["Name"] . "</td>";
                  echo "<td>" . $row["Email"] . "</td>";
                  echo "<td>" . $row["Phone_Number"] . "</td>";
                  echo "<td>" . $row["Password"] . "</td>";
                  echo "<td>" . $row["Address"] . "</td>";
                  echo "<td><a href='add_staff.php?edit_id=" . $row['ID'] . "'><i class='fa fa-edit ms-2'></i></a></td>";

                  echo "<td><a href='deletestaff.php?id=" . $row["ID"] . "' onclick='return confirm(\"Are you sure you want to delete this staff member?\");'><i class='fa fa-trash-o'></i></a></td>";
                  echo "</tr>";
                  $siNo++;
                }

              } else {
                echo "No data available";
              }

              $conn->close();
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <?php
  include "includes/script.php";
  ?>
  <script>
    $(document).ready(function () {
      $("#searchInput").on("keyup", function () {
        var value = $(this).val().toLowerCase();
        $("table tbody tr").filter(function () {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
    });
  </script>
</body>

</html>