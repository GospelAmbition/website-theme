<?php
/**
 * Gospel Ambition Theme Functions
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme Setup
 */
function gospel_ambition_setup() {
    // Add theme support for various features
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    
    // Add custom image sizes
    add_image_size('hero-image', 1200, 600, true);
    add_image_size('post-thumbnail', 400, 250, true);
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => esc_html__('Primary Menu', 'gospel-ambition'),
        'footer' => esc_html__('Footer Menu', 'gospel-ambition'),
    ));
    
    // Add support for custom logo
    add_theme_support('custom-logo', array(
        'height'      => 60,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ));
}
add_action('after_setup_theme', 'gospel_ambition_setup');

/**
 * Enqueue scripts and styles
 */
function gospel_ambition_scripts() {
    // Enqueue theme stylesheet
    wp_enqueue_style('gospel-ambition-style', get_stylesheet_uri(), array(), '1.0.0');
    
    // Enqueue Google Fonts
    wp_enqueue_style('gospel-ambition-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap', array(), '1.0.0');
    
    // Enqueue theme JavaScript
    wp_enqueue_script('gospel-ambition-script', get_template_directory_uri() . '/js/theme.js', array('jquery'), '1.0.0', true);
    

}
add_action('wp_enqueue_scripts', 'gospel_ambition_scripts');

/**
 * Register widget areas
 */
function gospel_ambition_widgets_init() {
    register_sidebar(array(
        'name'          => esc_html__('Sidebar', 'gospel-ambition'),
        'id'            => 'sidebar-1',
        'description'   => esc_html__('Add widgets here.', 'gospel-ambition'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    
    register_sidebar(array(
        'name'          => esc_html__('Footer Widgets', 'gospel-ambition'),
        'id'            => 'footer-widgets',
        'description'   => esc_html__('Add widgets to the footer area.', 'gospel-ambition'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="footer-widget-title">',
        'after_title'   => '</h4>',
    ));
}
add_action('widgets_init', 'gospel_ambition_widgets_init');

/**
 * Custom excerpt length
 */
function gospel_ambition_excerpt_length($length) {
    return 30;
}
add_filter('excerpt_length', 'gospel_ambition_excerpt_length');

/**
 * Custom excerpt more text
 */
function gospel_ambition_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'gospel_ambition_excerpt_more');



/**
 * Custom pagination
 */
function gospel_ambition_pagination() {
    global $wp_query;
    
    $big = 999999999;
    
    echo paginate_links(array(
        'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages,
        'prev_text' => '&laquo; Previous',
        'next_text' => 'Next &raquo;',
        'type' => 'list',
        'end_size' => 3,
        'mid_size' => 3
    ));
}

/**
 * Remove unnecessary WordPress features for performance
 */
function gospel_ambition_cleanup() {
    // Remove WordPress emoji scripts
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    
    // Remove WordPress generator meta tag
    remove_action('wp_head', 'wp_generator');
    
    // Remove RSD link
    remove_action('wp_head', 'rsd_link');
    
    // Remove Windows Live Writer
    remove_action('wp_head', 'wlwmanifest_link');
    
    // Remove feed links
    remove_action('wp_head', 'feed_links_extra', 3);
    remove_action('wp_head', 'feed_links', 2);
}
add_action('init', 'gospel_ambition_cleanup');

/**
 * Disable comments entirely
 */
function gospel_ambition_disable_comments() {
    // Disable comments for all post types
    $post_types = get_post_types();
    foreach ($post_types as $post_type) {
        if (post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
        }
    }
}
add_action('admin_init', 'gospel_ambition_disable_comments');

// Close comments on all posts
add_filter('comments_open', '__return_false', 20, 2);
add_filter('pings_open', '__return_false', 20, 2);

// Hide existing comments
add_filter('comments_array', '__return_empty_array', 10, 2);

// Remove comments page in menu
function gospel_ambition_remove_comments_page() {
    remove_menu_page('edit-comments.php');
}
add_action('admin_menu', 'gospel_ambition_remove_comments_page');

// Remove comments links from admin bar
function gospel_ambition_remove_comments_admin_bar() {
    if (is_admin_bar_showing()) {
        remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
    }
}
add_action('init', 'gospel_ambition_remove_comments_admin_bar');
