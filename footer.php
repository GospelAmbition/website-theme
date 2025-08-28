    <footer id="colophon" class="site-footer">
        <div class="footer-content">
            <div class="footer-description">
                <h3><?php bloginfo('name'); ?></h3>
                <p>Fulfilling the Great Commission in this generation, together</p>
            </div>

            <?php if (has_nav_menu('footer')) : ?>
                <nav class="footer-navigation">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer',
                        'menu_class'     => 'footer-links',
                        'depth'          => 1,
                    ));
                    ?>
                </nav>
            <?php else : ?>
                <div class="footer-links">
                    <a href="<?php echo esc_url(home_url('/blog/')); ?>">Blog</a>
                    <a href="<?php echo esc_url(home_url('/about/')); ?>">About</a>
                    <a href="<?php echo esc_url(home_url('/contact/')); ?>">Contact Us</a>
                    <a href="<?php echo esc_url(home_url('/give/')); ?>">Give</a>
                </div>
            <?php endif; ?>

            <?php if (is_active_sidebar('footer-widgets')) : ?>
                <div class="footer-widgets">
                    <?php dynamic_sidebar('footer-widgets'); ?>
                </div>
            <?php endif; ?>

            <div class="footer-copyright">
                <p>&copy; <?php echo esc_html(date('Y')); ?> <?php bloginfo('name'); ?>. All rights reserved.</p>
            </div>
        </div>
    </footer>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
