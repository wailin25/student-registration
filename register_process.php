<?php
session_start();
require 'includes/db.php';

// CSRF protection
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    $_SESSION['register_errors'] = ['Invalid request'];
    header("Location: register.php");
    exit();
}

// Form data validation
$errors = [];
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';
$role = $_POST['role'] ?? 'student';

// Validate inputs
if (empty($name)) {
    $errors[] = 'Name is required';
}

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Valid email is required';
} elseif (!str_ends_with($email, '@ucsmgy.edu.mm')) {
    $errors[] = 'Only @ucsmgy.edu.mm emails are allowed';
}

if (strlen($password) < 8 || strlen($password) > 12) {
    $errors[] = 'Password must be 8-12 characters';
}

if ($password !== $confirm_password) {
    $errors[] = 'Passwords do not match';
}

if (!in_array($role, ['student', 'staff'])) {
    $errors[] = 'Invalid role selected';
}

// Check if email already exists
$stmt = $mysqli->prepare("SELECT email FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $errors[] = 'Email already registered';
}

if (!empty($errors)) {
    $_SESSION['register_errors'] = $errors;
    $_SESSION['register_data'] = $_POST;
    header("Location: register.php");
    exit();
}

// Hash password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert new user
try {
    $stmt = $mysqli->prepare("INSERT INTO users (name, email, password, role, is_active, created_at) VALUES (?, ?, ?, ?, 1, NOW())");
    $stmt->bind_param("ssss", $name, $email, $hashed_password, $role);
    $stmt->execute();
    
    // Get the new user ID
    $user_id = $mysqli->insert_id;
    
    // Set session variables
    $_SESSION['user_id'] = $user_id;
    $_SESSION['user_name'] = $name;
    $_SESSION['user_email'] = $email;
    $_SESSION['user_role'] = $role;
    $_SESSION['logged_in'] = true;
    
    // Redirect to appropriate dashboard
    $redirect = ($role === 'student') ? 'student_dashboard.php' : 'staff_dashboard.php';
    header("Location: $redirect");
    exit();
    
} catch (Exception $e) {
    error_log("Registration error: " . $e->getMessage());
    $_SESSION['register_errors'] = ['Registration failed. Please try again.'];
    header("Location: register.php");
    exit();
}
?>