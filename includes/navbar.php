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

    <a class="" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample" style="position: relative;">
      🛒 Cart
      <span id="cart-count-badge" class="badge bg-primary" style="position: absolute; top: -18px; right: -10px;">
        <?php
        echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
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