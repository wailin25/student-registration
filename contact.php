<?php
require 'includes/header.php';
require 'includes/student_navbar.php';
?>
    <style>
        :root {
            --primary: #2c3e50;
            --secondary: #e74c3c;
            --accent: #3498db;
            --light: #ecf0f1;
            --dark: #2c3e50;
            --white: #ffffff;
        }
        
        * {
            font-family: 'Padauk', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background-image:url('image/CU1.jpg');
            color: var(--dark);
        }
        
        header {
            background-color: var(--primary);
            padding: 1rem 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }
        
        .logo {
            display: flex;
            align-items: center;
            color: var(--white);
        }
        
        .logo img {
            height: 50px;
            margin-right: 15px;
        }
        
        nav ul {
            display: flex;
            list-style: none;
        }
        
        nav ul li {
            margin-left: 2rem;
        }
        
        nav ul li a {
            color: var(--white);
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s;
            padding: 0.5rem 0;
            position: relative;
        }
        
        nav ul li a:hover {
            color: var(--accent);
        }
        
        nav ul li a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background-color: var(--accent);
            transition: width 0.3s;
        }
        
        nav ul li a:hover::after {
            width: 100%;
        }
        
        .contact-container {
            max-width: 700px;
            margin: 30px auto 20px;
            background-color: var(--white);
            box-shadow: 0 5px 30px rgba(0,0,0,0.1);
            border-radius: 10px;
            overflow: hidden;
        }
        
        .contact-header {
            background: linear-gradient(135deg, var(--primary), var(--dark));
            padding: 3rem 2rem;
            text-align: center;
            color: var(--white);
        }
        
        .contact-header h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        
        .contact-header p {
            font-size: 1.2rem;
            opacity: 0.9;
        }
        
        .contact-content {
            padding: 2rem;
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
        }
        
        .contact-info {
            flex: 1;
            min-width: 300px;
        }
        
        .contact-form {
            flex: 1;
            min-width: 300px;
        }
        
        .section-title {
            color: var(--primary);
            font-size: 1.8rem;
           
           margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--accent);
            position: relative;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100px;
            height: 2px;
            background-color: var(--secondary);
        }
        
        .info-card {
            background-color: var(--light);
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            box-shadow: 0 3px 15px rgba(0,0,0,0.05);
        }
        
        .info-card h3 {
            color: var(--primary);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }
        
        .info-card h3 i {
            margin-right: 10px;
            color: var(--accent);
        }
        
        .info-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 1rem;
        }
        
        .info-item i {
            color: var(--secondary);
            margin-right: 10px;
            margin-top: 3px;
        }
        
        .map-container {
            height: 300px;
            border-radius: 8px;
            overflow: hidden;
            margin-top: 2rem;
            box-shadow: 0 3px 15px rgba(0,0,0,0.1);
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-control {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }
        
      
        .form-control:focus {
            border-color: var(--accent);
            outline: none;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
        }
        
        textarea.form-control {
            min-height: 150px;
            resize: vertical;
        }
        
        .btn-submit {
            background-color: var(--accent);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            transition: all 0.3s;
        }
        
        .btn-submit:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
        }
        
        @media (max-width: 768px) {
            header {
                flex-direction: column;
                padding: 1rem;
            }
            
            nav ul {
                margin-top: 1rem;
                justify-content: center;
            }
            
            nav ul li {
                margin-left: 1rem;
                margin-right: 1rem;
            }
            
            .contact-container {
                margin: 80px 15px 30px;
            }
            
            .contact-content {
                flex-direction: column;
            }
        }
    </style>

    <!-- Main Content -->
    <div class="contact-container">
        <div class="contact-header">
            <h1><i class="fas fa-envelope"></i> Contact Us</h1>
            <p>Get in touch with University of Computer Studies (Magway)</p>
        </div>
        
        <div class="contact-content">
            <div class="contact-info">
                <div class="info-card">
                    <h3><i class="fas fa-info-circle"></i> Contact Information</h3>
                    
                    <div class="info-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <div>
                            <strong>Address:</strong><br>
                            Magway-Taungdwingyi Road, Magway Region, Myanmar
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <i class="fas fa-phone"></i>
                        <div>
                            <strong>Phone:</strong><br>
                            +95-9-5342859, +95-63-22245
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <i class="fas fa-envelope"></i>
                        <div>
                            <strong>Email:</strong><br>
                            info@ucsmgy.edu.mm
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <i class="fas fa-clock"></i>
                        <div>
                            <strong>Working Hours:</strong><br>
                            Monday to Friday (9:00 AM to 4:30 PM)
                        </div>
                    </div>
                </div>
                
                <div class="map-container">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3709.963434665053!2d95.12345678901234!3d20.123456789012345!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjDCsDA3JzI0LjQiTiA5NcKwMDcnMjQuNCJF!5e0!3m2!1sen!2smm!4v1234567890123!5m2!1sen!2smm" 
                            width="100%" 
                            height="100%" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy">
                    </iframe>
                </div>
            </div>
            
            <div class="contact-form">
                <div class="info-card">
                    <h3><i class="fas fa-paper-plane"></i> Send Us a Message</h3>
                    
                    <form action="#" method="POST">
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" id="name" name="name" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <input type="text" id="subject" name="subject" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="message">Your Message</label>
                            <textarea id="message" name="message" class="form-control" required></textarea>
                        </div>
                        
                        <button type="submit" class="btn-submit">
                            <i class="fas fa-paper-plane me-2"></i>Send Message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include "includes/footer.php"?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>