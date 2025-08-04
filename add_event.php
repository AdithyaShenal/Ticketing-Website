<?php
  session_start();
  if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
      header("Location: error_page.php");
      exit;
  }
?>

<?php include("db.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title>Add Event - Admin Control</title>

  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,700,900" rel="stylesheet" />
  <link href="css/sb-admin-2.css" rel="stylesheet" />
  <link href="css/custom.css" rel="stylesheet" />
  <style>
    #thumbnail-preview {
      margin-top: 10px;
      max-width: 300px;
      height: auto;
      border-radius: 8px;
      display: none;
    }
  </style>
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
      <a class="nav-link" href="dashboard_bookings.php">
        <i class="fas fa-calendar-check"></i><span>Booking Management</span>
      </a>
    </li>
    <li class="nav-item active">
      <a class="nav-link" href="dashboard_events.php">
        <i class="fas fa-calendar-alt"></i><span>Event Management</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#"><i class="fas fa-user-shield"></i><span>Privilege</span></a>
    </li>
    <hr class="sidebar-divider d-none d-md-block" />
    <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
  </ul>
  <!-- End Sidebar -->

  <!-- Content Wrapper -->
  <div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
      <?php include("includes/navbar.php"); ?>

      <!-- Page Content -->
      <div class="container-fluid">
        <p class="text-white my-3"><b>Add New Event</b></p>

        <form action="add_event_handler.php" method="POST" enctype="multipart/form-data">
          <div class="form-group mb-3 col-md-7">
            <label class="text-white">Title</label>
            <input type="text" name="title" class="form-control" required />
          </div>

          <div class="form-group mb-3 col-md-7">
            <label class="text-white">Location</label>
            <input type="text" name="location" class="form-control" required />
          </div>

          <div class="form-group mb-3 col-md-7">
            <label class="text-white">Event Date</label>
            <input type="date" name="event_date" class="form-control" required />
          </div>

          <div class="form-group mb-3 col-md-7">
            <label class="text-white">Category</label>
            <select name="category" class="form-control" required>
              <option value="concert">Concert</option>
              <option value="sports">Sports</option>
              <option value="seminar">Seminar</option>
            </select>
          </div>

          <div class="form-group mb-3 col-md-7">
            <label class="text-white">Thumbnail Image</label><br/>
            <input type="file"  name="thumbnail_file" accept="image/*" id="thumbnail-input" />
            <img id="thumbnail-preview" alt="Image Preview" />
          </div>

          <div class="form-check mb-3">
            <input type="checkbox" name="featured" class="form-check-input" value="1" id="featuredCheckbox" />
            <label class="form-check-label text-white" for="featuredCheckbox">Featured Event</label>
          </div>

          <button type="submit" class="btn btn-success">Add Event</button>
          <a href="dashboard_events.php" class="btn btn-secondary">Cancel</a>
        </form>
      </div>
    </div>
    <?php include("includes/footer.php"); ?>
  </div>
</div>

<a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>

<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="js/sb-admin-2.min.js"></script>

<!-- Image Preview Script -->
<script>
  document.getElementById('thumbnail-input').addEventListener('change', function (event) {
    const file = event.target.files[0];
    const preview = document.getElementById('thumbnail-preview');

    if (file) {
      const reader = new FileReader();
      reader.onload = function (e) {
        preview.src = e.target.result;
        preview.style.display = 'block';
      };
      reader.readAsDataURL(file);
    } else {
      preview.src = '';
      preview.style.display = 'none';
    }
  });
</script>
</body>
</html>
