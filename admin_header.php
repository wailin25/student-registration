<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<?php
require 'includes/db.php';

// Admin Authentication
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Initialize admin variables
$admin_name = $_SESSION['name'] ?? 'Admin';
$admin_email = $_SESSION['email'] ?? 'admin@ucsmgy.edu.mm';
$current_page = basename($_SERVER['PHP_SELF']);

// Define page groups for collapsible menus
$student_pages = ['upload_students.php', 'add_student.php', 'view_students.php'];
$subject_pages = ['add_subject.php', 'manage_subjects.php', 'pre_requisite.php'];
$allowed_pages = array_merge(
    ['admin_dashboard.php', 'view_registrations.php', 'update_info.php', 'statistics.php', 'profile.php', 'settings.php', 'logout.php'],
    $student_pages,
    $subject_pages
);
?>
<!DOCTYPE html>
<html lang="my">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UCSM Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Padauk&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --ucsm-blue: #1a3e8c;
            --ucsm-gold: #f8b739;
        }
        body {
            font-family: 'Padauk', sans-serif;
            background-color: #f8f9fa;
        }
        
        /* Adjust main content to account for fixed sidebar */
       /* Navbar အတွက် */
        .navbar-ucsm {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 500;
            height: 20px; /* Navbar အမြင့် */
            background-color: darkviolet;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        /* Sidebar အတွက် */
        .sidebar {
            position: fixed;
            top: 50px; /* Navbar အမြင့်နဲ့တူအောင် */
            left: 0;
            bottom: 0;
            width: 280px;
            background-color: cyan;
            overflow-y: auto;
            z-index: 1020;
            transition: transform 0.3s ease;
        }

        /* Main Content အတွက် */
        .main-content {
            margin-left: 280px;
            padding-top: 56px; /* Navbar အမြင့်နဲ့တူအောင် */
            min-height: calc(100vh - 56px);
            transition: margin-left 0.3s ease;
        }

        /* Sidebar ပိတ်ထားတဲ့အခါ */
        .sidebar.collapsed {
            transform: translateX(-280px);
        }

        .main-content.expanded {
            margin-left: 0;
        }
       
        .sidebar .nav-link {
            color: black;
            border-radius: 5px;
            margin-bottom: 5px;
            transition: all 0.2s;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background-color: var(--ucsm-gold);
            color: #000;
        }

        .toggle-btn {
            background: transparent;
            border: none;
            color: white;
            font-size: 1.25rem;
        }
        
        .user-dropdown {
            position: relative;
        }
        .user-dropdown-toggle {
            display: flex;
            align-items: center;
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            transition: all 0.3s;
        }
        .user-dropdown-toggle:hover {
            background-color: rgba(255,255,255,0.1);
        }
        .user-dropdown-menu {
            position: absolute;
            right: 0;
            top: 100%;
            min-width: 220px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            padding: 0.5rem 0;
            z-index: 1000;
            display: none;
        }
        .user-dropdown:hover .user-dropdown-menu {
            display: block;
        }
        .user-dropdown-item {
            display: flex;
            align-items: center;
            padding: 0.5rem 1.5rem;
            color: #333;
            text-decoration: none;
            transition: all 0.2s;
        }
        .user-dropdown-item:hover {
            background-color: #f8f9fa;
            color: var(--ucsm-blue);
        }
        .user-dropdown-item i {
            width: 25px;
            text-align: center;
            margin-right: 10px;
            color: var(--ucsm-blue);
        }
        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: var(--ucsm-gold);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            color: var(--ucsm-blue);
            font-weight: bold;
        }
    </style>
</head>
<body>