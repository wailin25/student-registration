<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UCSMGY Education System</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
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
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Padauk', 'Myanmar Text', sans-serif;
            background: url('image/CU1.jpg') no-repeat center center fixed;
            background-size: cover;
            color: var(--white);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            padding-top: 70px; /* To account for fixed navbar */
        }
        
        /* Fixed Navbar */
        header {
            background-color:var(--primary-dark);
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }
        
        .logo {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--white);
            display: flex;
            align-items: center;
        }
        
        .logo img {
            height: 70px;
            margin-right: 10px;
        }
        
        nav ul {
            display: flex;
            list-style: none;
        }
        
        nav ul li {
            margin-left: 1.5rem;
            position: relative;
        }
        
        nav ul li a {
            color: var(--white);
            text-decoration: none;
            transition: color 0.3s;
            font-weight: 600;
            padding: 0.5rem 0;
        }
        
        nav ul li a:hover {
            color: var(--secondary);
        }
        
        /* Active link indicator */
        nav ul li a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background-color: var(--secondary);
            transition: width 0.3s;
        }
        
        nav ul li a:hover::after {
            width: 100%;
        }
        
        main {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 2rem;
            background-color: rgba(0, 0, 0, 0.5);
        }
        
        .hero {
            max-width: 800px;
            margin-bottom: 2rem;
        }
        
        .hero h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: var(--white);
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        
        .hero p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            color: var(--light-gray);
        }
        
        .cta-buttons {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .btn {
            padding: 0.8rem 1.5rem;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s;
            min-width: 150px;
            text-align: center;
        }
        
        .btn-primary {
            background-color: var(--primary);
            color: var(--white);
            border: 2px solid var(--primary);
        }
        
        .btn-primary:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        .btn-secondary {
            background-color: var(--secondary);
            color: var(--dark-gray);
            border: 2px solid var(--secondary);
        }
        
        .btn-secondary:hover {
            background-color: #e0a42d;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        .portal-cards {
            display: flex;
            gap: 2rem;
            margin-top: 2rem;
            flex-wrap: wrap;
            justify-content: center;
        }
        
        .card {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 1.5rem;
            border-radius: 10px;
            width: 250px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }
        
        .card:hover {
            transform: translateY(-10px);
        }
        
        .card i {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 1rem;
        }
        
        .card h3 {
            margin-bottom: 1rem;
            color: var(--dark-gray);
        }
        
        footer {
            background-color: rgba(0, 0, 0, 0.8);
            padding: 1.5rem;
            text-align: center;
            color: var(--light-gray);
            font-size: 0.9rem;
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            header {
                flex-direction: column;
                padding: 1rem 0.5rem;
            }
            
            nav ul {
                margin-top: 1rem;
            }
            
            nav ul li {
                margin-left: 1rem;
            }
            
            .hero h1 {
                font-size: 2rem;
            }
            
            .cta-buttons {
                flex-direction: column;
                align-items: center;
            }
            
            .btn {
                width: 100%;
                max-width: 250px;
            }
        }.scroll-container {
    overflow: hidden;
    white-space: nowrap;
    flex: 1;
    padding-left: 20px;
    position: relative;
}

.scrolling-text {
    display: inline-block;
    animation: scroll-left 15s linear infinite;
    font-size: 1.1rem;
    font-weight: bold;
    color: var(--secondary);
}

@keyframes scroll-left {
    0% {
        transform: translateX(100%);
    }
    100% {
        transform: translateX(-100%);
    }
}

    </style>
</head>
<body>
    <header>
    
    <div class="scroll-container">
        <div class="scrolling-text">
            <img src="image/ucsmgy.png" alt="UCSMGY Logo" style="width: 50px; height: 60px; vertical-align: middle; margin-right: 10px;">
            <span>University of Computer Studies (Magway)</span>
        </div>
    </div>
    </header>


    <main>
        <div class="hero">
        
            <img src="image/ucsmgy.png" alt="UCSMGY Logo" style="width: 90px;height:100px;" >
            <h1>Welcome to UCSMGY Registration System</h1>
            <p>UCSMGYကျောင်းအပ်ခြင်းစနစ်မှကြိုဆိုပါတယ်ခင်များ။</p>
            
            <div class="cta-buttons">
                <a href="login.php" class="btn btn-primary">
                    <i class="fas fa-sign-in-alt"></i> Login
                </a>
                <a href="register.php" class="btn btn-secondary">
                    <i class="fas fa-user-plus"></i> Register
                </a>
            </div>
        </div>
    </main>

   <footer style="background-color: rgba(6, 32, 67, 0.95); padding: 20px 0; font-family: 'Segoe UI', Arial, sans-serif;">
    <div style="text-align: center; border-top: 1px solid rgba(255,255,255,0.2); padding-top: 15px; color: rgba(255,255,255,0.8); font-size: 14px;">
        <p>&copy; 2025 - Powered by <strong>University of Computer Studies (Magway)</strong></p>
    </div>
</footer>


<!-- Add Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</body>
</html>