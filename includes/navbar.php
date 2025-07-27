
<?php
session_start();


$loggedIn = isset($_SESSION['user']);
$userRole = $_SESSION['role'] ?? null;
?>

<header class="header">
  <div class="logo">Ticketist</div>
  <nav class="nav">
    <a href="index.php">Browse events</a>
    <a href="#">Help</a>

    <?php if ($loggedIn): ?>
      <a href="#">Profile</a>
      <?php if ($userRole === 'admin'): ?>
        <a href="#">Admin Panel</a>
      <?php endif; ?>
      <a href="logout.php">Logout</a>
    <?php else: ?>
      <a href="Ticketing-Website/login.php">Login</a>
      
    <?php endif; ?>
  </nav>
</header>
