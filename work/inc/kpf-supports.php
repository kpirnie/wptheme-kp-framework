<?php
/**
 * KP Theme Framework
 * 
 * A modern WordPress parent theme framework with CSS framework selection
 * 
 * @package KP Framework
 * @author Kevin Pirnie <me@kpirnie.com>
 * @version 1.0.0
 * @since 8.4
 * 
 */

// We don't want to allow direct access to this
defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

// Require Composer autoloader
if( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
    require_once __DIR__ . '/vendor/autoload.php';
}

// Load the main theme class
require_once __DIR__ . '/work/kpf-main.php';

/**
 * Theme Setup
 * 
 * @return void
 */
function kpf_theme_setup(): void {
    
    // Add theme support
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ] );
    add_theme_support( 'customize-selective-refresh-widgets' );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'wp-block-styles' );
    add_theme_support( 'align-wide' );
    
    // Editor styles
    add_theme_support( 'editor-styles' );
    
    // Register navigation menus
    register_nav_menus( [
        'primary' => __( 'Primary Menu', 'kpf' ),
        'footer' => __( 'Footer Menu', 'kpf' ),
    ] );

    // Load text domain
    load_theme_textdomain( 'kpf', get_template_directory() . '/languages' );

}
add_action( 'after_setup_theme', 'kpf_theme_setup', 1 );

/**
 * Register widget areas
 * 
 * @return void
 */
function kpf_widgets_init(): void {
    register_sidebar( [
        'name' => __( 'Primary Sidebar', 'kpf' ),
        'id' => 'sidebar-1',
        'description' => __( 'Add widgets here to appear in your sidebar.', 'kpf' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ] );

    register_sidebar( [
        'name' => __( 'Footer Widget Area', 'kpf' ),
        'id' => 'footer-1',
        'description' => __( 'Add widgets here to appear in your footer.', 'kpf' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ] );
}
add_action( 'widgets_init', 'kpf_widgets_init' );

/**
 * Add framework-specific body classes
 * 
 * @param array $classes Existing body classes
 * @return array
 */
function kpf_body_classes( array $classes ): array {
    // Add framework class
    $framework = kpf_get_framework();
    if( $framework !== 'none' ) {
        $classes[] = 'kpf-framework-' . $framework;
    }
    
    // Add no-framework class if none selected
    if( $framework === 'none' ) {
        $classes[] = 'kpf-no-framework';
    }

    return $classes;
}
add_filter( 'body_class', 'kpf_body_classes' );

/**
 * Customize Tailwind config via filter
 * 
 * @param array $config Default config
 * @return array
 */
function kpf_customize_tailwind_config( array $config ): array {
    // Extend theme colors
    $config['theme']['extend']['colors'] = [
        'primary' => '#3b82f6',
        'secondary' => '#6b7280',
    ];
    
    return $config;
}
add_filter( 'kpf_tailwind_config', 'kpf_customize_tailwind_config' );