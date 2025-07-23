<style>
/* ===== Footer Styles ===== */
footer {
    background: linear-gradient(135deg, #2b2d42, #1a1a2e);
    color: white;
    padding: 2.5rem 1rem;
    text-align: center;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    position: relative;
    margin-top: 3rem;
}

footer::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, #f72585, #4361ee, #4cc9f0);
}

footer p {
    margin: 0.5rem 0;
    font-size: 1rem;
    color: rgba(255, 255, 255, 0.8);
}

.footer-content {
    max-width: 1200px;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.footer-logo {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
    font-size: 1.5rem;
    font-weight: 700;
    color: white;
    text-decoration: none;
}

.footer-logo i {
    color: #f72585;
    font-size: 1.8rem;
}

.footer-links {
    display: flex;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
    justify-content: center;
}

.footer-links a {
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    transition: color 0.3s;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.footer-links a:hover {
    color: #4cc9f0;
}

.footer-links a i {
    font-size: 0.9rem;
}

.copyright {
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    font-size: 0.9rem;
    color: rgba(255, 255, 255, 0.6);
}

/* Responsive Design */
@media (max-width: 768px) {
    footer {
        padding: 2rem 1rem;
    }
    
    .footer-links {
        gap: 1rem;
        flex-direction: column;
        align-items: center;
    }
}
</style>

<footer>
    <div class="footer-content">
        <a href="index.php" class="footer-logo">
            <i class="fas fa-university"></i>
            UCSMGY
        </a>
        
        <div class="footer-links">
            <a href="about.php"><i class="fas fa-info-circle"></i> About Us</a>
            <a href="contact.php"><i class="fas fa-envelope"></i> Contact</a>
        </div>
        
        <div class="copyright">
            &copy; <?php echo date("Y"); ?> University of Computer Studies, Magway. All rights reserved.
        </div>
    </div>
</footer>