<?php
session_start();
require_once 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Get filters from query string
$filter = $_GET['filter'] ?? '';
$category = $_GET['category'] ?? '';
$search = $_GET['search'] ?? '';

try {
    $baseSql = "
        SELECT b.*, e.title AS event_title, e.location, e.event_date, e.category
        FROM bookings b
        JOIN events e ON b.event_id = e.id
        WHERE b.user_id = ?
    ";

    $params = [$user_id];

    // Time-based filter
    if ($filter === 'upcoming') {
        $baseSql .= " AND e.event_date >= CURDATE()";
    } elseif ($filter === 'past') {
        $baseSql .= " AND e.event_date < CURDATE()";
    }

    // Category filter
    if (!empty($category)) {
        $baseSql .= " AND e.category = ?";
        $params[] = $category;
    }

    // Search filter
    if (!empty($search)) {
        $baseSql .= " AND e.title LIKE ?";
        $params[] = '%' . $search . '%';
    }

    $baseSql .= " ORDER BY b.booking_date DESC";

    $stmt = $pdo->prepare($baseSql);
    $stmt->execute($params);
    $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Failed to fetch bookings: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Booking History</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/booking_history.css">
</head>
<body>
<?php include 'includes/navbar.php'; ?>

<div class="container">
    <h2 class="mb-4">Your Booking History</h2>

    <!-- Filter form -->
    <form method="GET" class="row mb-4">
        <div class="col-md-3">
            <select name="category" class="form-control">
                <option value="">All Categories</option>
                <option value="concert" <?= ($category === 'concert') ? 'selected' : '' ?>>Concert</option>
                <option value="sports" <?= ($category === 'sports') ? 'selected' : '' ?>>Sports</option>
            </select>
        </div>
        <div class="col-md-3">
            <select name="filter" class="form-control">
                <option value="">All Dates</option>
                <option value="upcoming" <?= ($filter === 'upcoming') ? 'selected' : '' ?>>Upcoming</option>
                <option value="past" <?= ($filter === 'past') ? 'selected' : '' ?>>Past</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Search</button>
        </div>
    </form>

    <!-- Booking Results -->
    <div class="booking-results">
        <?php if (empty($bookings)): ?>
            <div class="alert alert-info">No bookings found.</div>
        <?php else: ?>
            <?php foreach ($bookings as $booking): ?>
                <div class="card mb-3">
                    <div class="card-header">
                        <?= htmlspecialchars($booking['event_title']) ?>
                    </div>
                    <div class="card-body">
                        <p><strong>Location:</strong> <?= htmlspecialchars($booking['location']) ?></p>
                        <p><strong>Event Date:</strong> <?= htmlspecialchars($booking['event_date']) ?></p>
                        <p><strong>Category:</strong> <?= htmlspecialchars($booking['category']) ?></p>
                        <p><strong>Booked Seats:</strong> <?= htmlspecialchars($booking['no_of_seats']) ?></p>
                        <p><strong>Booking Date:</strong> <?= htmlspecialchars($booking['booking_date']) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

</body>

</html>
