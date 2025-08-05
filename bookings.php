<?php
include 'db.php';

$filter = $_GET['filter'] ?? '';
$today = date('Y-m-d');

$sql = "SELECT * FROM events";
if ($filter === 'upcoming') {
    $sql .= " WHERE event_date >= '$today'";
} elseif ($filter === 'past') {
    $sql .= " WHERE event_date < '$today'";
}
$sql .= " ORDER BY event_date ASC";

$events = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Events</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .event-badge {
            position: absolute;
            top: 0;
            left: 0;
            background-color: #0d6efd;
            color: white;
            padding: 0.25rem 0.6rem;
            font-size: 0.75rem;
            font-weight: bold;
            border-bottom-right-radius: 0.5rem;
        }

        .card {
            position: relative;
        }

        .filter-form {
            display: inline-block;
        }

        .card-header-custom {
            background-color: #0d6efd;
            color: white;
            font-weight: bold;
            padding: 10px;
        }

        .btn-white {
            background-color: white;
            border: 1px solid #ccc;
            color: #333;
        }

        .btn-white.active {
            border: 2px solid #0d6efd;
        }
    </style>
</head>
<body>
<div class="container my-4">
    <h2 class="mb-4">Events</h2>

    <form method="get" class="mb-4 filter-form">
        <select name="filter" class="form-select d-inline-block w-auto" onchange="this.form.submit()">
            <option value="" <?= $filter === '' ? 'selected' : '' ?>>All</option>
            <option value="upcoming" <?= $filter === 'upcoming' ? 'selected' : '' ?>>Upcoming</option>
            <option value="past" <?= $filter === 'past' ? 'selected' : '' ?>>Past</option>
        </select>
        <noscript><button type="submit" class="btn btn-white">Filter</button></noscript>
    </form>

    <div class="row">
        <?php if (empty($events)): ?>
            <div class="col-12">
                <div class="alert alert-info">No events found.</div>
            </div>
        <?php endif; ?>

        <?php foreach ($events as $event): ?>
            <?php
            $isUpcoming = $event['event_date'] >= $today;
            $badgeText = $isUpcoming ? 'Upcoming' : 'Past';
            ?>
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <div class="event-badge"><?= $badgeText ?></div>
                    <div class="card-header-custom">
                        <?= htmlspecialchars($event['title']) ?>
                    </div>
                    <div class="card-body">
                        <p><strong>Date:</strong> <?= htmlspecialchars($event['event_date']) ?></p>
                        <p><?= htmlspecialchars($event['description']) ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>
