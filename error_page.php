<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>404 - Page Not Found</title>
  <link rel="stylesheet" href="css/styles.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/error_page.css">
</head>
<body>

  <div class="error-container">
    <img src="assets/404_image.svg" alt="404 Cat" class="error-image">
    <h1>Oops! Page Not Found</h1>
    <p>Sorry, "Looks like this page ran off with our cat"</p>
    <a href="index.php" class="btn btn-primary" styles="text-decoration: none">Go to Home Page</a>
  </div>

  <footer>
    &copy; <?php echo date("Y"); ?> Ticketist. All rights reserved.
  </footer>

</body>
</html>
