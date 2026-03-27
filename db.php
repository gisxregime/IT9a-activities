<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbName = 'students_crud';

$conn = new mysqli($host, $user, $pass, $dbName);

if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
}
