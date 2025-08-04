<?php
include 'db.php';
header('Content-Type: application/json');

// Query 1: Daily bookings for last 7 days
$areaData = $pdo->query("
    SELECT DATE(booking_date) AS date, COUNT(*) AS total 
    FROM bookings 
    GROUP BY DATE(booking_date) 
    ORDER BY DATE(booking_date) DESC 
    LIMIT 7
")->fetchAll(PDO::FETCH_ASSOC);

// Query 2: Booking category ratio
$pieData = $pdo->query("
    SELECT e.category, COUNT(*) AS total
    FROM bookings b
    JOIN events e ON b.event_id = e.id
    GROUP BY e.category
")->fetchAll(PDO::FETCH_ASSOC);

// Reverse area data for chronological order
$areaData = array_reverse($areaData);

// Respond with JSON only
echo json_encode([
    'area' => $areaData,
    'pie'  => $pieData
]);
