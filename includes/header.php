<div class="container headersticky ps-0 pe-0">
  <nav class="navbar navbar-expand-lg navbar-light bg_navcolor ">
    <div class="container">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
        aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse " id="navbarNavDropdown">
        <ul class="navbar-nav nav_list">
          <li class="nav-item <?php echo isActive('index.php'); ?>">
            <a class="nav-link" href="index.php">Dashboard</a>
          </li>
          <li class="nav-item <?php echo isActive('manage_order.php'); ?>">
            <a class="nav-link" href="manage_order.php">Order</a>
          </li>
          <li class="nav-item <?php echo isActive('tailor_work_assign.php'); ?>">
            <a class="nav-link" href="tailor_work_assign.php">Assign</a>
          </li>
          <li class="nav-item <?php echo isActive('manage_tailor.php'); ?>">
            <a class="nav-link" href="manage_tailor.php">Tailor</a>
          </li>
          <li class="nav-item <?php echo isActive('manage_staff.php'); ?>">
            <a class="nav-link" href="manage_staff.php">Staff</a>
          </li>
          <li class="nav-item <?php echo isActive('tailor_summary.php'); ?>">
            <a class="nav-link" href="tailor_summary.php">Tailor Summary</a>
          </li>
        </ul>

        <?php
        // Function to check if the given page is the current page
        function isActive($page)
        {
          $currentPage = basename($_SERVER['SCRIPT_NAME']);
          return ($currentPage == $page) ? 'bgactive' : '';
        }
        ?>


      </div>
      <div class="d-flex justify-content-end">
        <ul class="navbar-nav nav_list">
          <li class="nav-item dropdown ">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
              data-bs-toggle="dropdown" aria-expanded="false">
              Welcome,
              <?php echo $_SESSION["Name"]; ?>
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <li><a class="dropdown-item" href="logout.php">Logout</a></li>
              <!-- <li><a class="dropdown-item" href="my_profile.php">Profile</a></li> -->
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>

</div>