<?php

$admin_name = $_SESSION['admin_name'] ?? 'Admin';
$admin_email = $_SESSION['admin_email'] ?? 'admin@ucsmgy.edu.mm';
?>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top shadow">
    <div class="container-fluid">
        <!-- Sidebar Toggle Button -->
        <button class="btn btn-primary me-3" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Brand -->
        <a class="navbar-brand d-flex align-items-center" href="admin_dashboard.php">
            <img src="image/ucsmgy.png" height="50" class="me-2">
            <span class="fw-bold">UCSM Admin Panel</span>
        </a>

        <!-- Right Side Dropdown -->
        <div class="dropdown ms-auto">
            <a class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
               id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false" href="#">
                <div class="bg-light text-primary rounded-circle d-flex justify-content-center align-items-center"
                     style="width: 36px; height: 36px;">
                    <strong><?= strtoupper(substr($admin_name, 0, 1)) ?></strong>
                </div>
                <span class="ms-2"><?= htmlspecialchars($admin_name) ?></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="dropdownUser">
                <li class="px-3 py-2">
                    <div class="fw-bold"><?= htmlspecialchars($admin_name) ?></div>
                    <div class="text-muted small"><?= htmlspecialchars($admin_email) ?></div>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="profile.php"><i class="fas fa-user me-2"></i>Profile</a></li>
                <li><a class="dropdown-item" href="settings.php"><i class="fas fa-cog me-2"></i>Settings</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
            </ul>
        </div>
    </div>
</nav>
<style>
    .sidebar-collapsed #sidebar {
        transform: translateX(-100%);
        transition: transform 0.3s ease;
    }

    .sidebar-collapsed #main-content {
        margin-left: 0 !important;
        transition: margin-left 0.3s ease;
    }

    #sidebar {
        transition: transform 0.3s ease;
    }

    #main-content {
        transition: margin-left 0.3s ease;
        margin-left: 280px;
    }
</style>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const toggleButton = document.getElementById("sidebarToggle");
        const body = document.body;

        toggleButton.addEventListener("click", function () {
            body.classList.toggle("sidebar-collapsed");
        });
    });
</script>
