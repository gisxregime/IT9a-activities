<?php
require_once __DIR__ . '/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php?status=error&msg=' . urlencode('Invalid request method.'));
    exit;
}

$id = (int) ($_POST['id'] ?? 0);
$studentId = trim($_POST['student_id'] ?? '');
$firstName = trim($_POST['first_name'] ?? '');
$lastName = trim($_POST['last_name'] ?? '');
$gender = trim($_POST['gender'] ?? '');
$email = trim($_POST['email'] ?? '');
$course = trim($_POST['course'] ?? '');
$phoneNo = trim($_POST['phone_no'] ?? '');

if ($id <= 0 || $studentId === '' || $firstName === '' || $lastName === '' || $gender === '' || $course === '') {
    header('Location: index.php?status=error&msg=' . urlencode('Invalid update request.'));
    exit;
}

$stmt = $conn->prepare('UPDATE students SET student_id = ?, first_name = ?, last_name = ?, gender = ?, email = ?, course = ?, phone_no = ? WHERE id = ?');
if (!$stmt) {
    header('Location: index.php?status=error&msg=' . urlencode('Database error: check students table in phpMyAdmin.'));
    exit;
}
$stmt->bind_param('sssssssi', $studentId, $firstName, $lastName, $gender, $email, $course, $phoneNo, $id);

if ($stmt->execute()) {
    header('Location: index.php?status=success&msg=' . urlencode('Student updated successfully.'));
    exit;
}

header('Location: index.php?status=error&msg=' . urlencode('Failed to update student.'));
exit;
