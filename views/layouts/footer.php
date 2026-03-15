    <?php if(Session::get('logged_in')): ?>
            </div> <!-- .main-content -->
        </div> <!-- .wrapper -->
    <?php endif; ?>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Sidebar submenu toggle
    document.querySelectorAll('.sidebar-menu .submenu > a').forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            this.parentElement.classList.toggle('open');
        });
    });
    </script>
</body>
</html>