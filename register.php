<?php
include 'db.php';
session_start();

$success = false;
$error = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name  = $_POST['name'];
    $email = $_POST['email'];
    $pass  = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role  = 'user';

    try {
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$name, $email, $pass, $role])) {
            $success = true;
        } else {
            $error = true;
        }
    } catch (PDOException $e) {
        // Generic error for any failure (e.g., duplicate email, DB error, etc.)
        $error = true;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register - Ticketist</title>
    <link rel="stylesheet" href="css/register.css">
</head>
<body>
    <div class="container">
        <h1 style="text-align: center; color: #3b82f6; margin-bottom: 1rem; font-weight: bold; font-size: 2rem;">
            Ticketist
        </h1>
        <h2>Register</h2>

        <form method="POST">
            <input type="text" name="name" placeholder="Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Register</button>
        </form>

        <p class="link-text">Already a user? <a href="login.php">Sign in here</a></p>
    </div>

    <!-- Popup logic -->
    <?php if ($success): ?>
        <script>
            alert("Registration successful! You can now log in.");
            window.location.href = "login.php";
        </script>
    <?php elseif ($error): ?>
        <script>
            alert("Something went wrong. Please try again later.");
        </script>
    <?php endif; ?>
</body>
</html>
