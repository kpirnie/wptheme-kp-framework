<?php
/** 
 * KP Theme Framework
 * 
 * A modern WordPress parent theme framework with CSS framework selection
 * 
 * @author Kevin Pirnie <iam@kevinpirnie.com>
 * @copyright 2025 Kevin Pirnie
 * 
 * @since 1.0.1
 * @author Kevin Pirnie <me@kpirnie.com>
 * @package KP Theme Framework
 * 
*/

// We don't want to allow direct access to this
defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

// fire up the main class
$kpf = new KPF_Main( );

// initialize it
$kpf -> initialize( );

// now clean up
unset( $kpf );

/**
 * Get theme option
 * 
 * @author Kevin Pirnie <iam@kevinpirnie.com>
 * @copyright 2025 Kevin Pirnie
 * 
 * @since 1.0.1
 * @package KP Theme Framework
 * @access public
 * 
 * @param string $key Option key
 * @param mixed $default Default value
 * @return mixed Returns the value of the option requested
 */
if( ! function_exists( 'get_option' ) ) {
    function get_option( string $key, mixed $default = null ): mixed {
        $options = get_option( 'kpf_theme_settings', [] );
        return $options[$key] ?? $default;
    }
}
