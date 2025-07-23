<?php
if (!isset($_SESSION)) session_start();
require_once 'includes/db.php';

// Access check
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'student') {
    header('Location: login.php');
    exit();
}
$student_name = $_SESSION['user_name'] ?? '';
$student_email = $_SESSION['user_email'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Dashboard - UCSMGY</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Fonts & Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Padauk&display=swap" rel="stylesheet">
    <style>
        /* Your shared CSS here or import external file */
    </style>
</head>
<body>
