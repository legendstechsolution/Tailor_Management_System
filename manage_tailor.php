<?php
session_start();

// Check if the user is not authenticated
if (!isset($_SESSION["Name"])) {
  header("Location: login.php"); // Redirect to the login page
  exit; // Ensure the script exits to prevent further execution
}
include 'connection.php';
$selectQuery = "SELECT * FROM manage_tailor ORDER BY ID  DESC";
$result = mysqli_query($conn, $selectQuery);
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
    <div class="container  card tailor  mt-2">
      <div class="">
        <P class="mt-3 ">Manage Tailor</P>
        <hr style="border: 1px solid black;">

        <div class="row mt-2">
          <div class="col-md-5 ">
            <input type="text" placeholder="Search" class="form-control" id="searchInput" />
          </div>
          <div class="col-md-7 text-end">
            <a href="add_tailor.php" class="btn btn-primary add  btn btn-primary">CREATE TAILOR</a>
          </div>
        </div>
        <div class="table-responsive   mt-4">
          <table class="table table-bordered text-center ">
            <thead class="table-secondary ">
              <tr>
                <th scope="col">SI.NO</th>
                <th scope="col">NAME</th>
                <th scope="col">EMAIL</th>
                <th scope="col">PHONE NO</th>
                <th scope="col">ADDRESS</th>
                <th scope="col">EDIT</th>
                <th scope="col">DELETE</th>
              </tr>
            </thead>
            <tbody>

              <?php
              $sino = 1;
              while ($row = mysqli_fetch_assoc($result)) {
                $name = $row["Name"];
                $email = $row["Email"];
                $phone = $row["Phone_Number"];
                $address = $row["Address"];
                $tailor_id = $row['ID'];
                echo "<tr>";
                echo "<td>$sino</td>";
                echo "<td>$name</td>";
                echo "<td>$email</td>";
                echo "<td>$phone</td>";
                echo "<td>$address</td>";
                echo "<td><a href='add_tailor.php?tailor_id=$tailor_id'><i class='fa fa-edit ms-2'></i></a></td>";
                echo "<td><a href='deletetailor.php?id=" . $row["ID"] . "'><i class='fa fa-trash-o'></i></a></td>";
                echo "</tr>";
                $sino++;
              }
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