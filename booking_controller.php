<?php
include 'db.php';

header("Content-Type: text/html");

$query = $_POST['query'] ?? '';
$category = $_POST['category'] ?? '';

// Build base SQL with JOINs
$sql = "
    SELECT 
        b.id AS booking_id, 
        b.event_id, 
        b.booking_date, 
        b.user_id,
        b.no_of_seats,
        u.name AS user_name,
        e.category
    FROM bookings b
    LEFT JOIN users u ON b.user_id = u.id
    LEFT JOIN events e ON b.event_id = e.id
    WHERE 1
";

// Prepare params array for PDO binding
$params = [];

// Filter by category if selected
if ($category !== '') {
    $sql .= " AND e.category = :category ";
    $params[':category'] = $category;
}

// Filter by booking ID or name if query provided
if ($query !== '') {
    // For booking ID, allow partial search like BKG001 = booking_id 1
    // So strip BKG prefix if present, and search user_name OR booking_id
    $queryLike = '%' . $query . '%';

    $sql .= " AND (u.name LIKE :query OR CAST(b.id AS CHAR) LIKE :queryLike) ";
    $params[':query'] = $queryLike;
    $params[':queryLike'] = $queryLike;
}

$sql .= " ORDER BY b.booking_date DESC LIMIT 50";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$bookings) {
        echo '<p class="text-white">No bookings found for your search.</p>';
        exit;
    }

    foreach ($bookings as $booking) {
        echo '
          <div class="booking-card">
            <div class="card mb-3 bg-dark text-white">
              <div class="card-body d-flex justify-content-between align-items-center flex-wrap">
                <div>
                  <h5 class="card-title">Booking ID: BKG' . str_pad($booking["booking_id"], 3, '0', STR_PAD_LEFT) . '</h5>
                  <p class="card-text mb-1">Name: ' . htmlspecialchars($booking["user_name"]) . '</p>
                  <p class="card-text mb-1">Event ID: EVT' . htmlspecialchars($booking["event_id"]) . '</p>
                  <p class="card-text mb-1">Category: ' . htmlspecialchars($booking["category"] ?? "Unknown") . '</p>
                  <p class="card-text">Date: ' . date("Y-m-d", strtotime($booking["booking_date"])) . '</p>
                </div>
                <div class="text-end">
                  <button class="btn btn-sm btn-warning">Block</button>
                  <button class="btn btn-sm btn-danger btn-remove" data-id="'.$booking["booking_id"].'">Remove</button>
                </div>
              </div>
            </div>
          </div>';

    }
} catch (Exception $e) {
    echo "<p class='text-danger'>Error loading bookings: " . $e->getMessage() . "</p>";
}
