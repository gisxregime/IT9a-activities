<?php
require_once __DIR__ . '/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php?status=error&msg=' . urlencode('Invalid request method.'));
    exit;
}

$id = (int) ($_POST['id'] ?? 0);

if ($id <= 0) {
    header('Location: index.php?status=error&msg=' . urlencode('Invalid delete request.'));
    exit;
}

$stmt = $conn->prepare('DELETE FROM students WHERE id = ?');
if (!$stmt) {
    header('Location: index.php?status=error&msg=' . urlencode('Database error: check students table in phpMyAdmin.'));
    exit;
}
$stmt->bind_param('i', $id);

if ($stmt->execute()) {
    header('Location: index.php?status=success&msg=' . urlencode('Student deleted successfully.'));
    exit;
}

header('Location: index.php?status=error&msg=' . urlencode('Failed to delete student.'));
exit;
