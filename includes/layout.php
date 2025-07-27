
<?php

function renderLayout($content) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Ticketist - Member 2</title>
  <link rel="stylesheet" href="css/styles.css" />
  
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet" />
</head>
<body>
  <?php include 'includes/navbar.php'; ?>
  <main>
    <?php echo $content; ?>
  </main>
  <?php include 'includes/footer.php'; ?>
</body>
</html>
<?php
}
?>
