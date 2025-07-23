<?php
session_start();
require 'includes/db.php';

if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - UCSMGY</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
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
    }
    
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Roboto', sans-serif;
    }
    
    body {
      background: url('image/CU5.jpg') no-repeat center center fixed;
      background-size: cover;
      min-height: 100vh;
      padding-top: 80px; /* Space for fixed navbar */
    }
    
    /* Fixed Navbar */
    .navbar {
      background-color: var(--primary);
      padding: 1rem 2rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 1000;
    }
    
    .logo {
      height: 50px;
    }
    
    .main-content {
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 2rem;
      min-height: calc(100vh - 80px);
    }
    
    .login-box {
      background: var(--white); 
      padding: 2.5rem; 
      border-radius: 10px; 
      box-shadow: 0 5px 25px rgba(0, 0, 0, 0.2);
      width: 100%; 
      max-width: 500px;
      animation: fadeIn 0.5s ease;
    }
    
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    .login-box h2 { 
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
      font-weight: 500;
    }
    
    .form-group input { 
      width: 100%; 
      padding: 0.8rem 1rem; 
      border: 1px solid #ddd; 
      border-radius: 5px; 
      font-size: 1rem;
      padding-right: 40px; /* Space for eye icon */
    }
    
    /* Adjusted Password Toggle */
    .toggle-password {
      position: absolute;
      right: 15px;
      top: 38px; /* Adjusted to align properly */
      transform: none; /* Removed previous transform */
      cursor: pointer;
      color: #666;
      background: none;
      border: none;
      padding: 0;
      font-size: 1rem;
    }
    
    .submit-btn {
      width: 100%;
      padding: 0.8rem;
      background-color: var(--primary);
      color: var(--white);
      border: none;
      border-radius: 5px;
      font-size: 1rem;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.3s;
    }
    
    .submit-btn:hover {
      background-color: var(--primary-dark);
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
    
    .remember-forgot {
      display: flex;
      justify-content: space-between;
      margin: 1rem 0;
      align-items: center;
    }
    
    .remember-me {
      display: flex;
      align-items: center;
    }
    
    .remember-me input {
      margin-right: 8px;
    }
    
    .link {
      text-align: center;
      margin-top: 1.5rem;
    }
    
    .link a {
      color: var(--primary);
      text-decoration: none;
      font-weight: 500;
    }
    
    .link a:hover {
      text-decoration: underline;
    }
    
    @media (max-width: 768px) {
      .login-box {
        padding: 1.5rem;
      }
      
      .navbar {
        padding: 1rem;
      }
    }
  </style>
</head>
<body>
  <!-- Fixed Navbar -->
  <nav class="navbar">
    <img src="image/ucsmgy.png" alt="UCSMGY Logo" class="logo" style="width:60px; height: 70px;">
    <marquee><h3>Welcome To Registration System</h3></marquee>
    <a href="index.php" class="back-btn">
      <i class="fas fa-arrow-left"></i> Back to Home
    </a>
  </nav>

  <div class="main-content">
    <div class="login-box">
      <h2>Login to Your Account</h2>
      
      <?php if (isset($_SESSION['error'])): ?>
        <div class="error">
          <i class="fas fa-exclamation-circle"></i> 
          <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
      <?php endif; ?>
      
      <form action="login_process.php" method="POST" id="loginForm">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        
        <div class="form-group">
          <label for="email">Edumail</label>
          <input type="email" id="email" name="email" 
                 placeholder="example@ucsmgy.edu.mm" 
                 required
                 value="<?php echo isset($_SESSION['login_email']) ? htmlspecialchars($_SESSION['login_email']) : ''; ?>">
        </div>
        
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" 
                 placeholder="Enter your password" 
                 required minlength="8">
          <button type="button" class="toggle-password" id="togglePassword" aria-label="Show password">
            <i class="fas fa-eye-slash"></i>
          </button>
        </div>
        
        <div class="remember-forgot">
          <div class="remember-me">
            <input type="checkbox" id="remember" name="remember">
            <label for="remember">Remember me</label>
          </div>
          <a href="forgot_password.php">Forgot password?</a>
        </div>
        
        <button type="submit" name="login" class="submit-btn" id="loginBtn">
          <span id="btnText">Login</span>
           <span id="spinner" class="hidden"><i class="fas fa-spinner fa-spin"></i></span>
        </button>
      </form>
      
      <div class="link">
        Don't have an account? 
        <a href="register.php">Register now</a>
      </div>
    </div>
  </div>

  <script>
    // Toggle password visibility
    document.getElementById('togglePassword').addEventListener('click', function() {
      const password = document.getElementById('password');
      const icon = this.querySelector('i');
      if (password.type === 'password') {
        password.type = 'text';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
      } else {
        password.type = 'password';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
      }
    });

    document.getElementById('loginForm').addEventListener('submit', function(e) {
      const email = document.getElementById('email').value;
      const password = document.getElementById('password').value;
      const btnText = document.getElementById('btnText');
      const spinner = document.getElementById('spinner');
      const loginBtn = document.getElementById('loginBtn');
      
      if (!email.endsWith('@ucsmgy.edu.mm')) {
        alert('Only UCSMGY Classroom email addresses are allowed');
        e.preventDefault();
        return;
      }
      
      if (password.length < 8 || password.length > 12) {
        alert('Password must be between 8-12 characters');
        e.preventDefault();
        return;
      }
      
      btnText.textContent = 'Logging in...';
      spinner.style.display = 'inline-block';
      loginBtn.disabled = true;
    });
  </script>
</body>
</html>
<?php
if (isset($_SESSION['login_email'])) {
    unset($_SESSION['login_email']);
}