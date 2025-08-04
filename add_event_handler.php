<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: dashboard_events.php");
    exit;
}

$title       = $_POST['title'] ?? '';
$location    = $_POST['location'] ?? '';
$event_date  = $_POST['event_date'] ?? '';
$category    = $_POST['category'] ?? '';
$featured    = isset($_POST['featured']) ? 1 : 0;
$thumbnail_url = null;

// === Image Upload Handling ===
if (isset($_FILES['thumbnail_file']) && $_FILES['thumbnail_file']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = 'uploads/events/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $tmpName = $_FILES['thumbnail_file']['tmp_name'];
    $originalName = basename($_FILES['thumbnail_file']['name']);
    $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

    // Allow only images
    $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
    if (!in_array($ext, $allowed)) {
        echo "❌ Invalid file type. Only images are allowed.";
        exit;
    }

    // Generate unique filename
    $uniqueName = uniqid('event_', true) . '.' . $ext;
    $destination = $uploadDir . $uniqueName;

    if (move_uploaded_file($tmpName, $destination)) {
        $thumbnail_url = $destination; // Save path to DB
    } else {
        echo "❌ Failed to upload image.";
        exit;
    }
}

// === Basic Form Validation ===
if (empty($title) || empty($location) || empty($event_date) || empty($category)) {
    echo "❌ All required fields must be filled.";
    exit;
}

try {
    $stmt = $pdo->prepare("
        INSERT INTO events (title, location, event_date, category, thumbnail_url, featured)
        VALUES (:title, :location, :event_date, :category, :thumbnail_url, :featured)
    ");

    $stmt->execute([
        ':title'         => $title,
        ':location'      => $location,
        ':event_date'    => $event_date,
        ':category'      => $category,
        ':thumbnail_url' => $thumbnail_url,
        ':featured'      => $featured
    ]);

    header("Location: dashboard_events.php?success=1");
    exit;

} catch (Exception $e) {
    echo "❌ Error adding event: " . $e->getMessage();
}
