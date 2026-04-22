<footer class="ds-footer">
    <div class="footer-content">
        <div class="footer-section">
            <h4>About</h4>
            <p>Your premium movie streaming experience. Discover thousands of movies in HD quality.</p>
        </div>
        <div class="footer-section">
            <h4>Quick Links</h4>
            <ul>
                <li><a href="<?php echo home_url('/'); ?>">Home</a></li>
                <li><a href="<?php echo get_post_type_archive_link('movies'); ?>">All Movies</a></li>
                <li><a href="<?php echo home_url('/contact'); ?>">Contact</a></li>
            </ul>
        </div>
        <div class="footer-section">
            <h4>Follow Us</h4>
            <div class="social-links">
                <a href="#" class="social-icon">Facebook</a>
                <a href="#" class="social-icon">Twitter</a>
                <a href="#" class="social-icon">Instagram</a>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; <?php echo date("Y"); ?> <?php bloginfo('name'); ?>. All rights reserved.</p>
    </div>
</footer>
<?php wp_footer(); ?>

</body>
</html>