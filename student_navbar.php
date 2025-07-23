<style>
/* ===== Fixed Navbar Styles ===== */
.navbar {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.8rem 2rem;
    background: linear-gradient(135deg, #3a0ca3, #4361ee);
    color: white;
    z-index: 1000;
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    flex-wrap: wrap; /* allow wrapping */
}

/* Body padding handled by JS dynamically */
body {
    transition: padding-top 0.2s ease;
}

/* Logo */
.logo {
    font-size: 1.5rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    color: white;
    text-decoration: none;
}

/* User greeting */
.user-greeting {
    margin-right: auto;
    margin-left: 2rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 500;
    background: rgba(255, 255, 255, 0.1);
    padding: 0.5rem 1rem;
    border-radius: 50px;
}

/* Navbar links */
.navbar ul {
    display: flex;
    gap: 0.5rem;
    list-style: none;
    margin: 0 1rem;
    padding: 0;
}

.navbar a {
    color: rgba(255, 255, 255, 0.9);
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.6rem 1.1rem;
    border-radius: 6px;
    transition: all 0.2s ease;
    font-weight: 500;
}

.navbar a:hover {
    background: rgba(255, 255, 255, 0.15);
}

.navbar a.active {
    background: rgba(255, 255, 255, 0.25);
    font-weight: 600;
}

/* Logout button */
.logout-btn {
    background: #f72585;
    color: white;
    border: none;
    padding: 0.6rem 1.3rem;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.2s;
}

.logout-btn:hover {
    background: #c9184a;
}

/* Responsive */
@media (max-width: 992px) {
    .navbar {
        flex-direction: column;
        padding: 1rem;
        text-align: center;
    }

    .logo, .user-greeting, .navbar ul, .logout-form {
        width: 100%;
        justify-content: center;
        margin: 0.3rem 0;
    }

    .navbar ul {
        flex-wrap: wrap;
        justify-content: center;
    }
}
</style>

<!-- ===== Navbar HTML ===== -->
<nav class="navbar">
    <a href="student_dashboard.php" class="logo">
        <image src="image/ucsmgy.png" alt="UCSM Logo" style="width: 50px; height: 60px;">UCSMGY
    </a>

    <div class="user-greeting">
        <i class="fas fa-user"></i> <?= htmlspecialchars($_SESSION['user_name'] ?? 'Student') ?>
    </div>

    <ul>
        <li>
            <a href="student_dashboard.php" <?= basename($_SERVER['PHP_SELF']) == 'student_dashboard.php' ? 'class="active"' : '' ?>>
                <i class="fas fa-home"></i> Home
            </a>
        </li>
        <li>
            <a href="registration_form.php" <?= basename($_SERVER['PHP_SELF']) == 'registration_form.php' ? 'class="active"' : '' ?>>
                <i class="fas fa-clipboard-list"></i> Registrations
            </a>
        </li>
        <li>
            <a href="rules.php" <?= basename($_SERVER['PHP_SELF']) == 'rules.php' ? 'class="active"' : '' ?>>
                <i class="fas fa-book"></i> Rules
            </a>
        </li>
        <li>
            <a href="contact.php" <?= basename($_SERVER['PHP_SELF']) == 'contact.php' ? 'class="active"' : '' ?>>
                <i class="fas fa-envelope"></i> Contact
            </a>
        </li>
        <li>
            <a href="about.php" <?= basename($_SERVER['PHP_SELF']) == 'about.php' ? 'class="active"' : '' ?>>
                <i class="fas fa-info-circle"></i> About
            </a>
        </li>
    </ul>

    <form action="logout.php" method="POST" class="logout-form">
        <button type="submit" class="logout-btn">
            <i class="fas fa-sign-out-alt"></i> Logout
        </button>
    </form>
</nav>

<!-- ✅ Dynamic padding fix using JS -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const navbar = document.querySelector(".navbar");
    if (navbar) {
        const height = navbar.offsetHeight;
        document.body.style.paddingTop = height + "px";
    }
});
</script>
