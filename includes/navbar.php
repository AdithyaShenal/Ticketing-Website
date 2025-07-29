
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

    <!-- 🛒 Cart Icon (Opens Sidebar) -->
    <a class="" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample" style="position: relative;">
      🛒 Cart
      <span class="badge bg-primary" style="position: absolute; top: -18px; right: -10px;">
        <?php
          $cart = isset($_COOKIE['cart']) ? json_decode($_COOKIE['cart'], true) : [];
          echo count($cart);
        ?>
      </span>
    </a>


    <?php if ($loggedIn): ?>
      <a href="#">Profile</a>
      <?php if ($userRole === 'admin'): ?>
        <a href="#">Admin Panel</a>
      <?php endif; ?>
      <a href="logout.php">Logout</a>
    <?php else: ?>
      <a href="login.php">Login</a>
    <?php endif; ?>
  </nav>
</header>
