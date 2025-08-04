<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$loggedIn = isset($_SESSION['user_id']);
$userRole = $_SESSION['role'] ?? null;
?>

<header class="header">
  <link rel="stylesheet" href="css/styles.css" />
  <div class="logo">Ticketist</div>
  <nav class="nav">
    <a href="index.php">Browse events</a>

    <?php if ($userRole === "user" && !empty($_SESSION['cart'])): ?>
      <a class="" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample" style="position: relative;">
        🛒 Cart
        <span id="cart-count-badge" class="badge bg-primary" style="position: absolute; top: -18px; right: -10px;">
          <?php echo count($_SESSION['cart']); ?>
        </span>
      </a>
    <?php endif; ?>

    <?php if ($loggedIn): ?>
        <a href="#">Profile</a>
        <a href="logout.php">Logout</a>
    <?php else: ?>
        <a href="login.php">Login</a>
    <?php endif; ?>
  </nav>
</header>
