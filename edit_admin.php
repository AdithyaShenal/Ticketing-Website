<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
  header("Location: error_page.php");
  exit;
}
require_once './db.php';

$id = intval($_GET['id'] ?? 0);
if ($id <= 0) {
  header("Location: dashboard_users.php");
  exit;
}

$errors = [];

// Fetch existing admin
$stmt = $pdo->prepare("SELECT name, email FROM users WHERE id = ? AND role = 'admin'");
$stmt->execute([$id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
  header("Location: dashboard_users.php");
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = trim($_POST['name']);
  $email = trim($_POST['email']);

  if (!$name || !$email) {
    $errors[] = "Name and Email are required.";
  }



  if (empty($errors)) {
    // Check if email is taken by another user
    $stmt2 = $pdo->prepare("SELECT id FROM users WHERE email = ? AND id <> ?");
    $stmt2->execute([$email, $id]);

    if ($stmt2->rowCount() > 0) {
      $errors[] = "Email already taken by another user.";
    } else {
      $stmt3 = $pdo->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
      if ($stmt3->execute([$name, $email, $id])) {
        header("Location: privilege.php");
        exit;
      } else {
        $errors[] = "Update failed.";
      }
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Edit Admin</title>
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" />
  <link href="css/sb-admin-2.css" rel="stylesheet" />
</head>
<body class="bg-dark text-white p-4">
  <div class="container">
    <h2>Edit Admin</h2>
    <?php if ($errors) foreach ($errors as $error): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endforeach; ?>
    <form method="post" novalidate>
      <div class="form-group">
        <label>Name</label>
        <input class="form-control" type="text" name="name" required value="<?= htmlspecialchars($user['name']) ?>" />
      </div>
      <div class="form-group">
        <label>Email</label>
        <input class="form-control" type="text" name="email" required value="<?= htmlspecialchars($user['email']) ?>" />
      </div>
      <button class="btn btn-primary" type="submit">Update</button>
      <a href="dashboard_users.php" class="btn btn-secondary">Cancel</a>
    </form>
  </div>
</body>
</html>