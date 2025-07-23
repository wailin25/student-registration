<?php
session_start();
require 'includes/db.php';

// Security headers
header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");
header("X-XSS-Protection: 1; mode=block");
header("Strict-Transport-Security: max-age=63072000; includeSubDomains; preload");

// Configuration
define('MAX_LOGIN_ATTEMPTS', 5);
define('LOGIN_LOCKOUT_TIME', 300); // 5 minutes in seconds
define('REMEMBER_ME_EXPIRY', 60 * 60 * 24 * 30); // 30 days

// Admin credentials (should be stored more securely in production)
$admin_credentials = [
    'email' => 'admin@ucsmgy.edu.mm',
    'password' => 'admin@123',
    'name' => 'System Admin',
    'role' => 'admin'
];

// Check CSRF token first
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    $_SESSION['error'] = 'Invalid request';
    header("Location: login.php");
    exit();
}

// Initialize login attempts if not set
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
    $_SESSION['last_attempt_time'] = time();
}

// Check if account is locked
if ($_SESSION['login_attempts'] >= MAX_LOGIN_ATTEMPTS) {
    if (time() - $_SESSION['last_attempt_time'] < LOGIN_LOCKOUT_TIME) {
        $_SESSION['error'] = 'Account locked. Try again in 5 minutes';
        header("Location: login.php");
        exit();
    } else {
        // Lockout period has expired
        $_SESSION['login_attempts'] = 0;
    }
}

// Validate inputs
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$password = $_POST['password'] ?? '';
$remember = isset($_POST['remember']);

// Basic validation
if (!filter_var($email, FILTER_VALIDATE_EMAIL) ){
    incrementLoginAttempts();
    $_SESSION['error'] = 'Invalid email format';
    $_SESSION['login_email'] = $email;
    header("Location: login.php");
    exit();
}

// Check email domain
if (!str_ends_with($email, '@ucsmgy.edu.mm')) {
    incrementLoginAttempts();
    $_SESSION['error'] = 'Only @ucsmgy.edu.mm emails are allowed';
    $_SESSION['login_email'] = $email;
    header("Location: login.php");
    exit();
}

try {
    // Check for admin login first
    if ($email === $admin_credentials['email'] && $password === $admin_credentials['password']) {
        handleSuccessfulLogin(0, $admin_credentials['name'], $email, $admin_credentials['role'], $remember);
        header("Location: admin_dashboard.php");
        exit();
    }

    // Database query for regular users
    $stmt = $mysqli->prepare("SELECT user_id, name, email, password, role, is_active FROM users WHERE email = ? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // Check if account is active
        if (!$user['is_active']) {
            $_SESSION['error'] = 'Account is inactive. Please contact administrator';
            $_SESSION['login_email'] = $email;
            header("Location: login.php");
            exit();
        }

        // Verify password
        if (password_verify($password, $user['password'])) {
            handleSuccessfulLogin($user['user_id'], $user['name'], $user['email'], $user['role'], $remember);
            
            $redirect = match($user['role']) {
                'student' => 'student_dashboard.php',
                'staff' => 'staff_dashboard.php',
                default => 'index.php'
            };
            header("Location: $redirect");
            exit();
        }
    }
    
    // If we reach here, login failed
    incrementLoginAttempts();
    $_SESSION['error'] = 'Invalid email or password';
    $_SESSION['login_email'] = $email;
    header("Location: login.php");
    exit();
    
} catch (Exception $e) {
    error_log("Database error during login: " . $e->getMessage());
    $_SESSION['error'] = 'System error. Please try again later';
    header("Location: login.php");
    exit();
}

/**
 * Increments login attempts counter
 */
function incrementLoginAttempts() {
    $_SESSION['login_attempts'] = ($_SESSION['login_attempts'] ?? 0) + 1;
    $_SESSION['last_attempt_time'] = time();
}

/**
 * Handles successful login (session setup and remember me functionality)
 */
function handleSuccessfulLogin($user_id, $name, $email, $role, $remember) {
    global $mysql;
    
    // Reset login attempts
    $_SESSION['login_attempts'] = 0;
    
    // Regenerate session ID to prevent session fixation
    session_regenerate_id(true);

    // Set session variables
    $_SESSION['user_id'] = $user_id;
    $_SESSION['user_name'] = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
    $_SESSION['user_email'] = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
    $_SESSION['user_role'] = $role;
    $_SESSION['logged_in'] = true;
    $_SESSION['last_activity'] = time();

    // Remember me functionality
    if ($remember) {
        setRememberMeToken($user_id);
    }
}

/**
 * Sets remember me token in database and cookie
 */
function setRememberMeToken($user_id) {
    global $mysqli;
    
    $token = bin2hex(random_bytes(32));
    $expiry = time() + REMEMBER_ME_EXPIRY;
    
    // Cleanup expired tokens first
    $mysqli->query("DELETE FROM remember_tokens WHERE expires_at < UNIX_TIMESTAMP()");
    
    $stmt = $mysqli->prepare("INSERT INTO remember_tokens (user_id, token, expires_at) VALUES (?, ?, ?)");
    $stmt->bind_param("isi", $user_id, $token, $expiry);
    $stmt->execute();
    
    setcookie('remember_token', $token, [
        'expires' => $expiry,
        'path' => '/',
        'domain' => '',
        'secure' => true,
        'httponly' => true,
        'samesite' => 'Strict'
    ]);
}
?>