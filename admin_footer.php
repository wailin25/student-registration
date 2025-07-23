<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('sidebarToggle').addEventListener('click', function() {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    const toggleIcon = this.querySelector('i');
    
    // Toggle classes
    sidebar.classList.toggle('collapsed');
    mainContent.classList.toggle('expanded');
    
    // Change icon
    toggleIcon.classList.toggle('fa-bars');
    toggleIcon.classList.toggle('fa-times');
    
    // Prevent default behavior that might cause jitter
    event.preventDefault();
});
</script>
</body>
</html>