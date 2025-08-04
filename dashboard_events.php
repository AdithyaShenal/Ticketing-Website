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

<body id="page-top" style="background-color: #212529;">
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

      <li class="nav-item">
        <a class="nav-link" href="dashboard_bookings.php">
          <i class="fas fa-calendar-check"></i>
          <span>Booking Management</span>
        </a>
      </li>

      <li class="nav-item active">
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

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <?php include("includes/navbar.php"); ?>

        <!-- Page Content -->
    <div class="container-fluid">
          <!-- Heading and Action -->
          <div class="d-sm-flex align-items-center justify-content-between my-4">
            <a href="add_event.php" class="btn btn-primary btn-sm">
              <i class="fas fa-plus"></i> Add New Event
            </a>
          </div>

      <!-- Filters -->
      <div class="row mb-3">
        <div class="col-md-5">
          <input type="text" class="form-control" placeholder="Search by Event Name" id="filter-event-name" />
        </div>
        <div class="col-md-4">
          <select class="form-control" id="filter-event-category">
            <option value="">All Categories</option>
            <option value="concert">Concert</option>
            <option value="sports">Sports</option>
            <option value="seminar">Seminar</option>
          </select>
        </div>
        <div class="col-md-3">
          <button id="btn-search-events" class="btn btn-primary w-100">Search</button>
        </div>
      </div>

        <!-- Events Grid -->
        <div class="row" id="event-grid">
        <div class="col-12 text-white">Loading events...</div>
        </div>
        <script src="vendor/jquery/jquery.min.js"></script>
        <script>
        $(document).ready(function () {
            $('#event-grid').load('event_controller.php');
        });
        </script>


        </div>
      </div>

      <!-- Footer -->
      <?php include("includes/footer.php"); ?>
    </div>
  </div>

  <!-- Scroll to Top -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Scripts -->
  <script>
  $(document).ready(function () {
    function loadEvents() {
      const name = $('#filter-event-name').val();
      const category = $('#filter-event-category').val();

      $('#event-grid').html('<div class="col-12 text-white">Loading events...</div>');

      $.post('event_controller.php', { name: name, category: category }, function (data) {
        $('#event-grid').html(data);
      });
    }

    // Initial load
    loadEvents();

    // Search button
    $('#btn-search-events').click(function () {
      loadEvents();
    });
  });
</script>
<script>
$(document).on('click', '.btn-delete-event', function () {
  if (!confirm('Are you sure you want to delete this event?')) return;

  const btn = $(this);
  const eventId = btn.data('id');

  $.post('delete_event.php', { event_id: eventId }, function (res) {
    if (res.success) {
      btn.closest('.col-md-4').fadeOut(300, function () { $(this).remove(); });
    } else {
      alert('Error: ' + res.message);
    }
  }, 'json').fail(function () {
    alert('Failed to connect to server.');
  });
});
</script>


  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/sb-admin-2.min.js"></script>
  <script src="vendor/chart.js/Chart.min.js"></script>
  <script src="js/demo/chart-area-demo.js"></script>
  <script src="js/demo/chart-pie-demo.js"></script>
</body>
</html>
