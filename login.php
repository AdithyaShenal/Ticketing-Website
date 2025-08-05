<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_start();
    $email = $_POST['email'];
    $pass  = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($pass, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role']    = $user['role'];
        $_SESSION['name']    = $user['name'];

        if ($user['role'] == 'admin') {
            header("Location: charts.php");
        } else {
            header("Location: user_dashboard.php");
        }
        exit;
    } else {
        echo "<script>alert('Invalid email or password.'); window.location.href='login.php';</script>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      height: 100vh;
      background-color: #222;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .login-container {
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(16px);
      border: 1px solid rgba(255, 255, 255, 0.2);
      border-radius: 1rem;
      padding: 2.5rem;
      width: 100%;
      max-width: 420px;
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
    }

    .login-container h2 {
      text-align: center;
      color: #ffffff;
      margin-bottom: 2rem;
      font-size: 1.8rem;
    }

    .input-group {
      margin-bottom: 1.5rem;
      position: relative;
    }

    .input-group i {
      position: absolute;
      top: 50%;
      left: 1rem;
      transform: translateY(-50%);
      color: #9ca3af;
    }

    .input-group input {
      width: 100%;
      padding: 0.75rem 0.75rem 0.75rem 2.5rem;
      border: none;
      border-radius: 0.5rem;
      background: rgba(255, 255, 255, 0.2);
      color: #fff;
      font-size: 1rem;
      outline: none;
      transition: all 0.2s ease-in-out;
    }

    .input-group input:focus {
      background: rgba(255, 255, 255, 0.3);
      border: 1px solid #3b82f6;
    }

    button {
      width: 100%;
      padding: 0.75rem;
      border: none;
      border-radius: 0.5rem;
      background-color: #3b82f6;
      color: white;
      font-weight: bold;
      font-size: 1rem;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    button:hover {
      background-color: #2563eb;
    }

    .link-text {
      margin-top: 1rem;
      text-align: center;
      font-size: 0.9rem;
      color: #d1d5db;
    }

    .link-text a {
      color: #60a5fa;
      text-decoration: none;
    }

    .link-text a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="login-container">
    <h1 style="text-align: center; color: #3b82f6; margin-bottom: 1rem; font-weight: bold; font-size: 2rem;">
      Ticketist
    </h1>
    <h2>User Login</h2>
    <form method="POST" action="login.php">
      <div class="input-group">
        <i class="fas fa-envelope"></i>
        <input type="email" name="email" placeholder="Email" required />
      </div>
      <div class="input-group">
        <i class="fas fa-lock"></i>
        <input type="password" name="password" placeholder="Password" required />
      </div>
      <button type="submit">Login</button>
    </form>
    <p class="link-text">
      Don't have an account? <a href="register.php">Sign up here</a>
    </p>
  </div>
</body>

</html>

