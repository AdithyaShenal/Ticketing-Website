<?php
$host = 'localhost';
$port = 3307;
$user = 'root';
$pass = '';
$db = 'ticketlist_db';

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db;port=$port", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("❌ Database connection failed: " . $e->getMessage());
}
?>
