    <?php if(Session::get('logged_in')): ?>
        </div><!-- .main-content -->
        </div><!-- .right-col -->
    </div><!-- .page-body -->
    <?php endif; ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    (function(){
        var img = new Image();
        img.onload = function(){ document.body.classList.add('bg-loaded'); };
        img.src = '<?php echo BASE_URL; ?>assets/images/bg_main.jpg';
    })();
    </script>
</body>
</html>
