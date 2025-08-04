<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pay_now'])) {
    $user_id = (int)$_POST['user_id'];
    $no_of_seats = (int)$_POST['no_of_seats'];
    $amount = $_POST['amount'];

    // Step 1: Insert into payments
    $stmt = $pdo->prepare("INSERT INTO payments (Amount) VALUES (:amount)");
    $stmt->execute(['amount' => $amount]);
    $payment_id = $pdo->lastInsertId();

    // Step 2: Insert bookings from cart session
    foreach ($_SESSION['cart'] as $item) {
        $stmt = $pdo->prepare("INSERT INTO bookings (user_id, event_id, no_of_seats, booking_date, payment_id) 
                               VALUES (:user_id, :event_id, :no_of_seats, NOW(), :payment_id)");
        $stmt->execute([
            'user_id' => $user_id,
            'event_id' => $item['id'],
            'no_of_seats' => $no_of_seats,
            'payment_id' => $payment_id
        ]);
    }

    // Clear cart
    unset($_SESSION['cart']);
    $_SESSION['success_message'] = "Payment completed successfully!";

    // Redirect to home
    header("Location: index.php");
    exit;
}
