<!-- Please use your own database connection details here (Xampp Configuration details) -->

<?php
$host = 'localhost';
$port = 3306;
$user = 'root';
$pass = '';
$db = 'ticketing_system';

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db;port=$port", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("❌ Database connection failed: " . $e->getMessage());
}
?>
