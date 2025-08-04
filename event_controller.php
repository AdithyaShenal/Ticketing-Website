<?php
include 'db.php';
header('Content-Type: text/html');

$name = $_POST['name'] ?? '';
$category = $_POST['category'] ?? '';

$sql = "SELECT * FROM events WHERE 1";
$params = [];

if ($name !== '') {
    $sql .= " AND title LIKE :name";
    $params[':name'] = "%$name%";
}
if ($category !== '') {
    $sql .= " AND category = :category";
    $params[':category'] = $category;
}

$sql .= " ORDER BY event_date ASC";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$events) {
        echo '<div class="col-12 text-white">No events found.</div>';
        exit;
    }

    foreach ($events as $event) {
        echo '
        <div class="col-md-4 mb-4">
          <div class="card bg-dark text-white h-100">
            <img src="' . htmlspecialchars($event["thumbnail_url"]) . '" class="card-img-top" style="height:200px;object-fit:cover;" />
            <div class="card-body">
              <h5 class="card-title">' . htmlspecialchars($event["title"]) . '</h5>
              <p class="card-text mb-1">Event ID: EVT' . $event["id"] . '</p>
              <p class="card-text mb-1">Category: ' . $event["category"] . '</p>
              <p class="card-text mb-1">Date: ' . $event["event_date"] . '</p>
              <p class="card-text">Location: ' . htmlspecialchars($event["location"]) . '</p>
              <button class="btn btn-sm btn-info">Edit</button>
              <button class="btn btn-sm btn-danger btn-delete-event" data-id="' . $event["id"] . '">Delete</button>
            </div>
          </div>
        </div>';
    }
} catch (Exception $e) {
    echo '<div class="col-12 text-danger">Error: ' . $e->getMessage() . '</div>';
}
