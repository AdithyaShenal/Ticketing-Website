<?php
session_start();
require_once 'db.php';

// Optional: calculate cart total from session
$total = 0;
foreach ($_SESSION['cart'] ?? [] as $item) {
  $total += $item['price'] * $item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Checkout</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
  <h2 class="mb-4">Checkout</h2>

  <form method="POST" action="checlout_proceed.php">
    <!-- Credit Card Details -->
    <div class="mb-3">
      <label class="form-label">Cardholder Name</label>
      <input type="text" name="card_name" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Card Number</label>
      <input type="text" name="card_number" maxlength="16" class="form-control" required>
    </div>

    <div class="row">
      <div class="col-md-6 mb-3">
        <label class="form-label">Expiry Date</label>
        <input type="text" name="expiry_date" placeholder="MM/YY" class="form-control" required>
      </div>
      <div class="col-md-6 mb-3">
        <label class="form-label">CVV</label>
        <input type="text" name="cvv" maxlength="4" class="form-control" required>
      </div>
    </div>

    <!-- Other Booking Inputs -->
    <div class="mb-3">
      <label class="form-label">Number of Seats</label>
      <input type="number" name="no_of_seats" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Total Amount</label>
      <input type="text" name="amount" class="form-control" readonly value="<?= $total ?>">
    </div>

    <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?? 1 ?>">

    <button type="submit" name="pay_now" class="btn btn-success w-100">Pay Now</button>
  </form>
</div>

</body>
</html>
