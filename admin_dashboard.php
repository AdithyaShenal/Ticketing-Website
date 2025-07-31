<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}
$name = $_SESSION['name'];
$image = $_SESSION['image'] ?? 'default.jpg'; // default fallback
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Panel</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      margin: 0;
      padding: 0;
      display: flex;
    }

    .sidebar {
      width: 250px;
      background-color: #343a40;
      color: #fff;
      min-height: 100vh;
      padding-top: 1rem;
      position: fixed;
      transition: transform 0.3s ease;
    }

    .sidebar a {
      color: #adb5bd;
      text-decoration: none;
      padding: 10px 20px;
      display: block;
    }

    .sidebar a:hover {
      background-color: #495057;
      color: #fff;
    }

    .main-content {
      margin-left: 250px;
      padding: 20px;
      width: 100%;
    }

    .profile-img {
      width: 40px;
      height: 40px;
      object-fit: cover;
      border-radius: 50%;
    }

    /* Responsive styles */
    @media (max-width: 768px) {
      .sidebar {
        transform: translateX(-100%);
        position: fixed;
        z-index: 1050;
      }

      .sidebar.show {
        transform: translateX(0);
      }

      .main-content {
        margin-left: 0;
        width: 100%;
      }

      .menu-btn {
        display: inline-block;
        margin-right: 10px;
      }
    }
  </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
  <h5 class="text-center text-white mb-4">Admin Panel</h5>
<a href="add_event.php" class="btn btn-glass w-100 mb-2">Add Event</a>
<a href="manage_events.php" class="btn btn-glass w-100 mb-2">Manage Events</a>
<a href="manage_users.php" class="btn btn-glass w-100 mb-2">User Management</a>
<style>
    .btn-glass {
        background: rgba(255, 255, 255, 0.15);
        border: 1px solid rgba(255,255,255,0.2);
        color: #fff;
        backdrop-filter: blur(6px);
        box-shadow: 0 4px 24px 0 rgba(0,0,0,0.10);
        transition: background 0.2s, color 0.2s, border 0.2s;
        border-radius: 0.5rem;
        font-weight: 500;
    }
    .btn-glass:hover, .btn-glass:focus {
        background: rgba(255,255,255,0.25);
        color: #212529;
        border: 1px solid #fff;
        text-decoration: none;
    }
</style>
</div>

<!-- Main content -->
<div class="main-content">
  <!-- Top bar -->
  <nav class="d-flex justify-content-between align-items-center mb-4">
    <!-- Menu Icon for Mobile -->
    <button class="btn btn-dark d-md-none menu-btn" onclick="toggleSidebar()">☰</button>

    <div class="dropdown ms-auto">
      <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
        <img src="uploads/<?php echo $image ?>" alt="User" class="profile-img me-2">
        <strong><?php echo htmlspecialchars($name); ?></strong>
      </a>
      <ul class="dropdown-menu dropdown-menu-end">
        <li><a class="dropdown-item" href="profile.php">👤 Profile</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item text-danger" href="logout.php">🚪 Logout</a></li>
      </ul>
    </div>
  </nav>

  <h2>Welcome, <?php echo htmlspecialchars($name); ?> 👋</h2>
  <p>Select an action from the sidebar to get started.</p>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('show');
  }
</script>
</body>
</html>
