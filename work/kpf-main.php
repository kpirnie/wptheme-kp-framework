<?php
/** 
 * 
 * This is the primary theme class file. 
 * It is responsible for pulling together everything for us to use
 * 
 * @author Kevin Pirnie <iam@kevinpirnie.com>
 * @copyright 2025 Kevin Pirnie
 * 
 * @since 1.0.1
 * @package KP Theme Framework
 * 
*/

// We don't want to allow direct access to this
defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

// make sure we aren't loading in the class multiple times
if( ! class_exists( 'KPF_Main' ) ) {

    /** 
     * KPF_Main
     * 
     * @author Kevin Pirnie <iam@kevinpirnie.com>
     * @copyright 2025 Kevin Pirnie
     * 
     * @since 1.0.1
     * @package KP Theme Framework
     * @access public
     * 
    */
    class KPF_Main {

        /**
         * Initialize the theme's functionality
         * 
         * @author Kevin Pirnie <iam@kevinpirnie.com>
         * @copyright 2025 Kevin Pirnie
         * 
         * @since 1.0.1
         * @package KP Theme Framework
         * @access public
         * @static
         * 
         * @return void Returns nothing
         */
        public static function init( ) : void {

            // setup the theme's defined constants
            self::define_constants( );

            // initialize the hooks we'll utilize
            self::init_hooks( );

        }

        /**
         * Define theme constants
         * 
         * @author Kevin Pirnie <iam@kevinpirnie.com>
         * @copyright 2025 Kevin Pirnie
         * 
         * @since 1.0.1
         * @package KP Theme Framework
         * @access private
         * @static
         * 
         * @return void Returns nothing
         */
        private static function define_constants(): void {
            
            // Theme version
            defined( 'KPF_VERSION' ) || define( 'KPF_VERSION', wp_get_theme()->get( 'Version' ) ?? '1.0.0' );
            
            // Theme paths
            defined( 'KPF_PATH' ) || define( 'KPF_PATH', get_template_directory() );
            defined( 'KPF_URL' ) || define( 'KPF_URL', get_template_directory_uri() );
            defined( 'KPF_WORK_PATH' ) || define( 'KPF_WORK_PATH', KPF_PATH . '/work' );
            defined( 'KPF_INC_PATH' ) || define( 'KPF_INC_PATH', KPF_WORK_PATH . '/inc' );
            defined( 'KPF_ASSETS_URL' ) || define( 'KPF_ASSETS_URL', KPF_URL . '/assets' );
        }

        /**
         * Initialize hooks
         * 
         * @author Kevin Pirnie <iam@kevinpirnie.com>
         * @copyright 2025 Kevin Pirnie
         * 
         * @since 1.0.1
         * @package KP Theme Framework
         * @access private
         * @static
         * 
         * @return void Returns nothing
         */
        private static function init_hooks(): void {

            // Initialize theme settings
            add_action( 'after_setup_theme', function( ) { 

                // fire up the settings class
                new KPF_Settings( );

            }, 10 );
            
            // Enqueue assets
            add_action( 'wp_enqueue_scripts', function( ) {

                // fire up the asset class
                $assets = new KPF_Framework_Loader( );

                // properly enqueue our assets
                $assets -> enqueue_framework( );

                // clean up
                unset( $assets );
                
                
            }, 10 );
            
            // Admin assets
            add_action( 'admin_enqueue_scripts', function( ) {


                
            }, 10 );

            // initialization
            add_action( 'init', function( ) { return false; } );

        }

    }

}