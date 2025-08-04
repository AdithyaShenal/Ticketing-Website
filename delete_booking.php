<?php
include 'db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$bookingId = $_POST['booking_id'] ?? null;
if (!$bookingId || !is_numeric($bookingId)) {
    echo json_encode(['success' => false, 'message' => 'Invalid booking ID']);
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM bookings WHERE id = :id");
    $stmt->execute([':id' => $bookingId]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true, 'message' => 'Booking removed']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Booking not found']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
