<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['event_id'])) {
    $eventId = (int)$_POST['event_id'];

    // Fetch event details from database
    $stmt = $pdo->prepare("SELECT id, title, location, event_date, thumbnail_url FROM events WHERE id = :id");
    $stmt->execute(['id' => $eventId]);
    $event = $stmt->fetch();

    if ($event) {
        // Add to session cart
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // If event already in cart, increase quantity
        if (isset($_SESSION['cart'][$eventId])) {
            $_SESSION['cart'][$eventId]['quantity'] += 1;
        } else {
            $_SESSION['cart'][$eventId] = [
                'id' => $event['id'],
                'title' => $event['title'],
                'location' => $event['location'],
                'event_date' => $event['event_date'],
                'thumbnail_url' => $event['thumbnail_url'],
                'quantity' => 1
            ];
        }
    }
}

// Redirect back to homepage
header('Location: index.php');
exit;
