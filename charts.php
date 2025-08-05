<?php
  session_start();
  if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
      header("Location: error_page.php");
      exit;
  }
?>

<?php
include 'db.php';

// Daily Earnings
$dailyEarnings = $pdo->query("
    SELECT SUM(CAST(p.Amount AS DECIMAL(10,2))) 
    FROM bookings b
    JOIN payments p ON b.payment_id = p.id
    WHERE DATE(b.booking_date) = CURDATE()
")->fetchColumn() ?: 0;

// Monthly Earnings
$monthlyEarnings = $pdo->query("
    SELECT SUM(CAST(p.Amount AS DECIMAL(10,2))) 
    FROM bookings b
    JOIN payments p ON b.payment_id = p.id
    WHERE MONTH(b.booking_date) = MONTH(CURDATE())
      AND YEAR(b.booking_date) = YEAR(CURDATE())
")->fetchColumn() ?: 0;

// Daily Bookings
$dailyBookings = $pdo->query("
    SELECT COUNT(*) 
    FROM bookings 
    WHERE DATE(booking_date) = CURDATE()
")->fetchColumn() ?: 0;

// Upcoming Events
$upcomingEvents = $pdo->query("
    SELECT COUNT(*) 
    FROM events 
    WHERE event_date >= CURDATE()
")->fetchColumn() ?: 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title>Admin Control</title>

  <!-- Fonts & Styles -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet" />
  <link href="css/sb-admin-2.css" rel="stylesheet" />
  <link href="css/custom.css" rel="stylesheet" />
</head>

<body id="page-top" class="custom-background-color" style="background-color: #212529;">
  <div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav sidebar-custom-color sidebar sidebar-dark accordion" id="accordionSidebar">
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

        <div class="container-fluid">

          <!-- Dashboard Cards -->
          <div class="row mt-4">
            <!-- Daily Earnings -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Earnings (Daily)</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">$<?= number_format($dailyEarnings, 2) ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Monthly Earnings -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Earnings (Monthly)</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">$<?= number_format($monthlyEarnings, 2) ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-coins fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Daily Bookings -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Bookings (Today)</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $dailyBookings ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-ticket-alt fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Upcoming Events -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Upcoming Events</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $upcomingEvents ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Charts Row -->
          <div class="row">
            <!-- Area Chart -->
            <div class="col-xl-8 col-lg-7">
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Daily Bookings</h6>
                </div>
                <div class="card-body">
                  <div class="chart-area">
                    <canvas id="myAreaChart"></canvas>
                  </div>
                </div>
              </div>
            </div>

            <!-- Pie Chart -->
            <div class="col-xl-4 col-lg-5">
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Booking Ratio</h6>
                </div>
                <div class="card-body">
                  <div class="chart-pie pt-4">
                    <canvas id="myPieChart"></canvas>
                  </div>
                  <hr />
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- End of Page Content -->
      </div>
      <!-- End of Main Content -->

    </div>
    <!-- End of Content Wrapper -->
  </div>
  <!-- End of Page Wrapper -->

  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Scripts -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/sb-admin-2.min.js"></script>
  <script src="vendor/chart.js/Chart.min.js"></script>
  <script src="js/demo/chart-area-live.js"></script>
  <script src="js/demo/chart-pie-live.js"></script>
</body>
</html>
