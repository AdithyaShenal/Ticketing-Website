<?php
  session_start();
  if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
      header("Location: error_page.php");
      exit;
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />

  <title>Admin Control</title>

  <!-- Fonts and Icons -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,700,900" rel="stylesheet" />

  <!-- Styles -->
  <link href="css/sb-admin-2.css" rel="stylesheet" />
  <link href="css/custom.css" rel="stylesheet" />
</head>

<body id="page-top" class="custom-background-color" style="background-color: #212529;">
  <div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav sidebar sidebar-dark bg-dark accordion" id="accordionSidebar">
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="mx-3">Dashboard</div>
      </a>

      <hr class="sidebar-divider" />

      <li class="nav-item">
        <a class="nav-link" href="charts.php">
          <i class="fas fa-calendar-check"></i>
          <span>Analytics</span>
        </a>
      </li>

      <li class="nav-item active">
        <a class="nav-link" href="dashboard_bookings.php">
          <i class="fas fa-calendar-check"></i>
          <span>Booking Management</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="dashboard_events.php">
          <i class="fas fa-calendar-alt"></i>
          <span>Event Management</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="privilege.php">
          <i class="fas fa-user-shield"></i>
          <span>Privilege</span>
        </a>
      </li>

      <hr class="sidebar-divider d-none d-md-block" />

      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>
    </ul>
    <!-- End of Sidebar -->

    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <?php include("includes/navbar.php"); ?>

        <!-- Page Content -->
        <div class="container-fluid">
          <!-- Filter Row -->
          <div class="row my-3">
            <div class="col-md-5">
              <input
                type="text"
                id="search-query"
                class="form-control"
                placeholder="Search by Name or Booking ID"
                autocomplete="off"
              />
            </div>
            <div class="col-md-4">
              <select id="filter-category" class="form-control">
                <option value="">All Categories</option>
                <option value="concert">Concert</option>
                <option value="sports">Sports</option>
                <option value="seminar">Seminar</option>
              </select>
            </div>
            <div class="col-md-3">
              <button id="btn-search" class="btn btn-primary w-100">Search</button>
            </div>
          </div>

          <!-- Booking Results -->
          <div id="booking-cards">
            <div class="text-white">Please enter search criteria and click Search.</div>
          </div>
        </div>
      </div>

      <?php include("includes/footer.php"); ?>
    </div>
  </div>

  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Scripts -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/sb-admin-2.min.js"></script>

  <!-- Chart.js and other demo scripts (optional) -->
  <script src="vendor/chart.js/Chart.min.js"></script>
  <script src="js/demo/chart-area-demo.js"></script>
  <script src="js/demo/chart-pie-demo.js"></script>

  <!-- Custom JS for Booking Management -->
  <script>
    $(document).ready(function () {
      // Search button click
      $('#btn-search').click(function () {
        const query = $('#search-query').val();
        const category = $('#filter-category').val();

        $('#booking-cards').html('<div class="text-white">Loading bookings...</div>');

        $.post('booking_controller.php', { query: query, category: category }, function (data) {
          $('#booking-cards').html(data);
        });
      });

      // Remove button handler
      $(document).on('click', '.btn-remove', function () {
  if (!confirm('Are you sure you want to remove this booking?')) return;

  const btn = $(this);
  const bookingId = btn.data('id');

  $.post('delete_booking.php', { booking_id: bookingId }, function (response) {
    if (response.success) {
      btn.closest('.booking-card').fadeOut(300, function () {
        $(this).remove();
      });
    } else {
      alert('Error: ' + response.message);
    }
  }, 'json').fail(function () {
    alert('Failed to contact server');
  });
});

    });
  </script>
</body>
</html>
