<?php
session_start();

header('Content-Type: application/json');

if (!isset($_GET['id'])) {
    echo json_encode(['success' => false, 'error' => 'No ID provided']);
    exit;
}

$id = (int)$_GET['id'];

if (!isset($_SESSION['cart'][$id])) {
    echo json_encode(['success' => false, 'error' => 'Item not found in cart']);
    exit;
}

unset($_SESSION['cart'][$id]);

echo json_encode(['success' => true]);
exit;
