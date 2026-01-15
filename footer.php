<?php
/**
 * Footer template
 * 
 * @package KP Framework
 */
?>

    <footer id="colophon" class="site-footer">
        <?php kpf_container(); ?>
        
        <?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
            <div class="footer-widgets">
                <?php dynamic_sidebar( 'footer-1' ); ?>
            </div>
        <?php endif; ?>

        <div class="site-info">
            <?php
            wp_nav_menu( [
                'theme_location' => 'footer',
                'menu_id' => 'footer-menu',
                'container' => false,
                'fallback_cb' => false,
                'depth' => 1,
            ] );
            ?>
            <p>&copy; <?php echo date( 'Y' ); ?> <?php bloginfo( 'name' ); ?></p>
        </div>
        
        <?php kpf_container_end(); ?>
    </footer>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>