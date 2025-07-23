<?php
session_start();
require 'includes/db.php';
// Redirect to home if already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

// CSRF Token Generation
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create New Account - UCSMGY</title>
  <!-- Suggested: Latest version -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Padauk:wght@400;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --primary: #4a6baf;
      --primary-light: #5d7bc1;
      --primary-dark: #3a5688;
      --secondary: #f8b739;
      --white: #ffffff;
      --light-gray: #f5f5f5;
      --dark-gray: #333333;
      --error: #e74c3c;
      --success: #2ecc71;
      --warning: #f39c12;
      --overlay: rgba(0, 0, 0, 0.7);
    }
    
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    body {
      font-family: 'Padauk', sans-serif;
      color: var(--dark-gray);
      background: url('image/CU5.jpg') no-repeat center center fixed;
      background-size: cover;
      min-height: 100vh;
      overflow-x: hidden;
    }
    
    /* Navigation Bar */
    .navbar {
      background-color: var(--primary);
      padding: 1rem 2rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      position: fixed;
      width: 100%;
      top: 0;
      z-index: 1000;
    }
    
    .logo {
      height: 50px;
    }
    
    .nav-links {
      display: flex;
      list-style: none;
      align-items: center;
    }
    
    .nav-links li {
      margin-left: 2rem;
    }
    
    .nav-links a {
      color: var(--white);
      text-decoration: none;
      font-weight: 700;
      font-size: 1.1rem;
      transition: all 0.3s ease;
    }
    
    .nav-links a:hover {
      color: var(--secondary);
    }
    
    .login-btn {
      background-color: var(--secondary);
      color: var(--dark-gray);
      border: none;
      padding: 0.5rem 1.5rem;
      border-radius: 5px;
      font-weight: 700;
      cursor: pointer;
      transition: all 0.3s ease;
      font-family: 'Padauk', sans-serif;
    }
    
    .login-btn:hover {
      background-color: var(--white);
      transform: translateY(-2px);
    }
    
    /* Main Content */
    .main-content {
      margin-top: 80px;
      padding: 2rem;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: calc(100vh - 80px);
    }
    
    /* Register Box */
    .register-box { 
      background: var(--white); 
      padding: 2.5rem; 
      border-radius: 10px; 
      box-shadow: 0 5px 25px rgba(0, 0, 0, 0.2);
      width: 100%; 
      max-width: 500px;
      position: relative;
      animation: fadeIn 0.5s ease;
    }
    
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    .register-box h2 { 
      text-align: center; 
      margin-bottom: 1.5rem; 
      color: var(--primary);
      font-size: 1.8rem;
    }
    
    .form-group { 
      margin-bottom: 1.5rem; 
      position: relative;
    }
    
    .form-group label { 
      display: block; 
      margin-bottom: 0.5rem; 
      font-weight: 700;
      color: var(--dark-gray);
    }
    
    .form-group input, 
    .form-group select { 
      width: 100%; 
      padding: 0.8rem 1rem; 
      border: 1px solid #ddd; 
      border-radius: 5px; 
      font-size: 1rem;
      font-family: 'Padauk', sans-serif;
      transition: all 0.3s;
    }
    
    .form-group input:focus,
    .form-group select:focus {
      border-color: var(--primary);
      outline: none;
      box-shadow: 0 0 0 3px rgba(74, 107, 175, 0.2);
    }
    
    .submit-btn {
      width: 100%;
      padding: 0.8rem;
      background-color: var(--primary-light);
      color: var(--white);
      border: none;
      border-radius: 5px;
      font-size: 1rem;
      font-weight: 700;
      cursor: pointer;
      transition: all 0.3s;
      margin-top: 0.5rem;
    }
    
    .submit-btn:hover {
      background-color: var(--primary-dark);
    }
    
    .link {
      text-align: center;
      margin-top: 1.5rem;
      font-size: 0.9rem;
    }
    
    .link a {
      color: var(--primary);
      text-decoration: none;
      font-weight: 700;
    }
    
    .link a:hover {
      text-decoration: underline;
    }
    
    .error {
      color: var(--error);
      background-color: rgba(231, 76, 60, 0.1);
      padding: 0.8rem;
      border-radius: 5px;
      border: 1px solid var(--error);
      margin-bottom: 1.5rem;
      text-align: center;
    }
    
    .success {
      color: var(--success);
      background-color: rgba(46, 204, 113, 0.1);
      padding: 0.8rem;
      border-radius: 5px;
      border: 1px solid var(--success);
      margin-bottom: 1.5rem;
      text-align: center;
    }
    
    .password-container {
      position: relative;
    }
    
    .toggle-password {
      position: absolute;
      right: 12px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      color: #666;
      font-size: 1.1rem;
      background: none;
      border: none;
    }
    
    .password-hint {
      font-size: 13px;
      color: #666;
      margin-top: 8px;
      display: flex;
      align-items: center;
    }
    
    .password-hint i {
      margin-right: 5px;
      font-size: 12px;
    }
    
    .password-strength {
      height: 4px;
      background: #ddd;
      border-radius: 2px;
      margin-top: 8px;
      overflow: hidden;
      position: relative;
    }
    
    .strength-meter {
      height: 100%;
      width: 0%;
      transition: all 0.3s;
    }
    
    .strength-text {
      font-size: 12px;
      margin-top: 4px;
      text-align: right;
      color: #666;
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
      .navbar {
        padding: 1rem;
      }
      
      .nav-links li {
        margin-left: 1rem;
      }
      
      .main-content {
        margin-top: 70px;
      }
    }
    
    @media (max-width: 480px) {
      .register-box {
        padding: 1.5rem;
        margin: 0 1rem;
      }
      
      .nav-links li {
        margin: 0 0.5rem;
      }
    }
  </style>
</head>
<body>
  <!-- Navigation Bar -->
  <nav class="navbar">
    
    <img src="image/ucsmgy.png" alt="UCSMGY Logo" class="logo" style="width:60px; height: 70px;">
    <marquee><h3>Welcome to Registration System</h3></marquee>
    <div class="nav-right">
        <a href="index.php" class="back-btn">
            <i class="fas fa-arrow-left"></i> Back to Home
        </a>
    </div>
  </nav>

  <!-- Main Content -->
  <div class="main-content">
    <div class="register-box">
      <h2>Create New Account</h2>
      
      <?php if (isset($_SESSION['register_success'])): ?>
        <div class="success">Registration successful</div>
        <?php unset($_SESSION['register_success']); ?>
      <?php endif; ?>
      
      <?php if (isset($_SESSION['register_errors'])): ?>
        <?php foreach ($_SESSION['register_errors'] as $error): ?>
          <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endforeach; ?>
        <?php unset($_SESSION['register_errors']); ?>
      <?php endif; ?>
      
      <form action="register_process.php" method="POST" id="register-form">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        
        <div class="form-group">
          <label for="name">Username</label>
          <input type="text" id="name" name="name" required
                 value="<?php echo isset($_SESSION['register_data']['name']) ? htmlspecialchars($_SESSION['register_data']['name']) : ''; ?>">
        </div>
        
        <div class="form-group">
          <label for="email">Edumail</label>
          <input type="email" id="email" name="email" 
                 placeholder="example@ucsmgy.edu.mm" 
                 aria-required="true" required
                 value="<?php echo isset($_SESSION['register_data']['email']) ? htmlspecialchars($_SESSION['register_data']['email']) : ''; ?>">
        </div>
        
        <div class="form-group">
          <label for="password">Password</label>
          <div class="password-container">
            <input type="password" id="password" name="password" 
                   placeholder="Create password (8-12 characters)" 
                   aria-required="true" required minlength="8" maxlength="12"
                   oninput="checkPasswordStrength()">
            <button type="button" class="toggle-password" id="togglePassword" aria-label="Show password">
              <i class="fas fa-eye-slash"></i>
            </button>
          </div>
          <div class="password-hint">
            <i class="fas fa-info-circle"></i>
            <span>8-12 characters, include numbers and special characters</span>
          </div>
          <div class="password-strength">
            <div class="strength-meter" id="strengthMeter"></div>
          </div>
          <div class="strength-text" id="strengthText">Password Strength</div>
        </div>
        
        <div class="form-group">
          <label for="confirm_password">Confirm Password</label>
          <div class="password-container">
            <input type="password" id="confirm_password" name="confirm_password" required>
            <button type="button" class="toggle-password" id="toggleConfirmPassword" aria-label="Show password">
              <i class="fas fa-eye-slash"></i>
            </button>
          </div>
        </div>
        
        <div class="form-group">
          <label for="role">Role</label>
          <select id="role" name="role" required>
            <option value="" disabled selected>Select your role</option>
            <option value="student" <?php echo (isset($_SESSION['register_data']['role']) && $_SESSION['register_data']['role'] === 'student') ? 'selected' : ''; ?>>
              Student
            </option>
            <option value="staff" <?php echo (isset($_SESSION['register_data']['role']) && $_SESSION['register_data']['role'] === 'staff') ? 'selected' : ''; ?>>
              Staff
            </option>
          </select>
        </div>
        
        <button type="submit" class="submit-btn" id="register-btn">
          <span id="btn-text">Register Now</span>
          <span id="spinner" class="hidden"><i class="fas fa-spinner fa-spin"></i></span>
        </button>
      </form>
      
      <div class="link">
        Already have an account? 
        <a href="login.php">Login here</a>
      </div>
    </div>
  </div>

  <script>
    // Password visibility toggle
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');
    const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
    const confirmPassword = document.getElementById('confirm_password');

    togglePassword.addEventListener('click', function() {
      const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
      password.setAttribute('type', type);
      this.querySelector('i').classList.toggle('fa-eye-slash');
      this.querySelector('i').classList.toggle('fa-eye');
    });

    toggleConfirmPassword.addEventListener('click', function() {
      const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
      confirmPassword.setAttribute('type', type);
      this.querySelector('i').classList.toggle('fa-eye-slash');
      this.querySelector('i').classList.toggle('fa-eye');
    });

    // Password strength checker
    function checkPasswordStrength() {
      const password = document.getElementById('password').value;
      const strengthMeter = document.getElementById('strengthMeter');
      const strengthText = document.getElementById('strengthText');
      let strength = 0;
      
      // Length check
      if (password.length >= 8) strength += 1;
      if (password.length >= 10) strength += 1;
      
      // Character variety checks
      if (/[A-Z]/.test(password)) strength += 1;
      if (/[0-9]/.test(password)) strength += 1;
      if (/[^A-Za-z0-9]/.test(password)) strength += 1;
      
      const width = strength * 20;
      strengthMeter.style.width = width + '%';
      
      if (strength <= 2) {
        strengthMeter.style.backgroundColor = 'var(--error)';
        strengthText.textContent = 'Weak';
        strengthText.style.color = 'var(--error)';
      } else if (strength <= 4) {
        strengthMeter.style.backgroundColor = 'var(--warning)';
        strengthText.textContent = 'Medium';
        strengthText.style.color = 'var(--warning)';
      } else {
        strengthMeter.style.backgroundColor = 'var(--success)';
        strengthText.textContent = 'Strong';
        strengthText.style.color = 'var(--success)';
      }
    }

    // Form validation
    document.getElementById('register-form').addEventListener('submit', function(e) {
      const email = document.getElementById('email').value;
      const password = document.getElementById('password').value;
      const confirmPassword = document.getElementById('confirm_password').value;
      
      // Email validation
      if (!email.endsWith('@ucsmgy.edu.mm')) {
        alert('Only @ucsmgy.edu.mm emails are allowed');
        e.preventDefault();
        return;
      }
      
      // Password validation
      if (password.length < 8 || password.length > 12) {
        alert('Password must be between 8-12 characters');
        e.preventDefault();
        return;
      }
      
      // Password match validation
      if (password !== confirmPassword) {
        alert('Passwords do not match. Please re-enter your password');
        e.preventDefault();
        return;
      }
      
      // Show loading state
      document.getElementById('btn-text').textContent = 'Processing...';
      document.getElementById('spinner').classList.remove('hidden');
      document.getElementById('register-btn').disabled = true;
    });
    
    // Clear session data when leaving page
    window.addEventListener('beforeunload', function() {
      fetch('clear_register_session.php', {
        method: 'POST',
        credentials: 'same-origin'
      });
    });
  </script>
</body>
</html>
<?php 
// Clear register data from session after displaying
if (isset($_SESSION['register_data'])) {
    unset($_SESSION['register_data']);
}
?>