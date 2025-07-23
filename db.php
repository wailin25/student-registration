<?php
// db.php

// Database configuration
$host = "localhost";      // or your DB host
$user = "root";           // your DB username
$password = "";           // your DB password
$database = "kowai";  // your DB name

// Create a new mysqli connection
$mysqli = new mysqli($host, $user, $password, $database);

// Check connection
if ($mysqli->connect_error) {
    // Handle connection error gracefully
    die("Database connection failed: " . $mysqli->connect_error);
}

// Set character set to utf8mb4 for full Unicode support (recommended)
$mysqli->set_charset("utf8mb4");
?>