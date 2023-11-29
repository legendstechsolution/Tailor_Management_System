<?php
session_start();

// Check if the user is not authenticated
if (!isset($_SESSION["Name"])) {
  header("Location: login.php"); // Redirect to the login page
  exit; // Ensure the script exits to prevent further execution
}

include 'connection.php';

// Initialize filter variables
$selectedTailorId = "all";
$fromDate = "";
$toDate = "";
$sql = "SELECT
    manage_tailor.*,
    total_quantity.total_qty AS total_qty,
    total_earned.total_earned,
    SUM(payments.amount) AS total_paid
FROM manage_tailor
LEFT JOIN (
    SELECT tailor_id, SUM(quantity) AS total_qty
    FROM tailor_assign
    GROUP BY tailor_id
) AS total_quantity ON manage_tailor.ID = total_quantity.tailor_id
LEFT JOIN (
    SELECT tailor_id, SUM(quantity * rate) AS total_earned
    FROM tailor_assign
    GROUP BY tailor_id
) AS total_earned ON manage_tailor.ID = total_earned.tailor_id
LEFT JOIN payments ON manage_tailor.ID = payments.tailorId


";
// Handle filter values from the form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["clear"])) {
    $result = $conn->query($sql);

  } else {
    $selectedTailorId = $_POST["tailor_id"];
    $fromDate = $_POST["from_date"];
    $toDate = $_POST["to_date"];
  }


}
if ($selectedTailorId !== "all") {
  $sql .= " WHERE manage_tailor.ID = $selectedTailorId";
}

if (!empty($fromDate) && !empty($toDate)) {
  // Add conditions for filtering by date ranges
  $fromDate = $conn->real_escape_string($fromDate);
  $toDate = $conn->real_escape_string($toDate);
  // Add conditions for filtering by date ranges
  $sql .= " AND (tailor_assign.created_date BETWEEN '$fromDate' AND '$toDate' OR payments.createddate BETWEEN '$fromDate' AND '$toDate')";

}
$sql .= " GROUP BY manage_tailor.ID";
$result = $conn->query($sql);
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

  <div class="col-md-12 scrollable-content overflow-auto" style="height:582px">
    <div class="container card mt-3">
      <div class="mt-3">
        <P class="mt-3">Tailor Summary</P>
        <hr style="border: 1px solid black;">
        <div class="">
          <form method="post">
            <div class="row mb-3">
              <div class="col-md-2 col-sm-4 ">
                <input type="text" class="form-control" placeholder="Search" id="searchInput">
              </div>
              <div class="col-md-2 col-sm-4">
                <select class="form-select" name="tailor_id" aria-label="Select Tailor">
                  <option value="all" <?= $selectedTailorId == "all" ? "selected" : "" ?>>Select Tailor</option>
                  <?php
                  // Fetch tailor data from the database
                  $sqlquery = "SELECT * FROM manage_tailor";
                  $fullresult = $conn->query($sqlquery);
                  if ($fullresult->num_rows > 0) {
                    while ($data = $fullresult->fetch_assoc()) {
                      echo '<option value="' . $data['ID'] . '" ' . ($selectedTailorId == $data['ID'] ? "selected" : "") . '>' . $data['Name'] . '</option>';
                    }
                  }
                  ?>
                </select>
              </div>
              <div class="col-md-3 col-sm-4">
                <div class="input-group">
                  <label class="input-group-text">From :</label>
                  <input type="date" class="form-control " name="from_date" value="<?= $fromDate ?>">
                </div>
              </div>
              <div class="col-md-3 col-sm-4">
                <div class="input-group">
                  <label class="input-group-text">To :</label>
                  <input type="date" class="form-control " name="to_date" value="<?= $toDate ?>">
                </div>
              </div>
              <div class="col-md-2 col-sm-2 d-flex flex-nowrap ">
                <button type="submit" class="btn p-1 btn-primary profile-button " id="applyFilters">Submit</button>
                <button type="submit" name="clear" class=" p-1 btn btn-secondary ms-1   close_button">CLEAR</button>

              </div>

            </div>
          </form>
        </div>
        <div class="">
          <div class="table-responsive">
            <table class="table tailor table-bordered text-center">
              <thead class="table-secondary">
                <tr>
                  <th>SI.NO</th>
                  <th>Name</th>
                  <th>Oty Produced</th>
                  <th>Total Earned</th>

                  <th>Advance</th>
                  <th>Balance</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $serialNo = 1;
                if ($result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . $serialNo . '</td>';
                    echo '<td>' . $row['Name'] . '</td>'; // Column 2: Name
                    echo '<td>' . $row['total_qty'] . '</td>'; // Column 3: Total Quantity Taken
                    echo '<td>' . $row['total_earned'] . '</td>'; // Column 4: Total Earned
                    echo '<td>' . $row['total_paid'] . '</td>'; // New column for Payments
                    echo '<td>' . ($row['total_earned'] - $row['total_paid']) . '</td>'; // New column for Payments
                
                    // You can add more logic for Advance and Balance columns here if needed
                    echo '</tr>';
                    $serialNo++;
                  }
                } else {
                  echo '<tr><td colspan="5">No data found</td></tr>';
                }
                ?>
              </tbody>

            </table>
          </div>
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
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
      });

      $("#applyFilters").click(function () {
        // Construct and submit the form for filtering
        $("form").submit();
      });
    });
  </script>
</body>

</html>