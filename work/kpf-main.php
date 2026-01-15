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
         * Instance of the class
         * 
         * @author Kevin Pirnie <iam@kevinpirnie.com>
         * @copyright 2025 Kevin Pirnie
         * 
         * @since 1.0.1
         * @package KP Theme Framework
         * @access private
         * 
         * @var KPF_Main
         */
        private ?KPF_Main $_instance = null;

        /**
         * Constructor
         */
        public function __construct() {
            $this->define_constants();
            $this->init_hooks();
        }

        /**
         * Get the instance of the class
         * 
         * @author Kevin Pirnie <iam@kevinpirnie.com>
         * @copyright 2025 Kevin Pirnie
         * 
         * @since 1.0.1
         * @package KP Theme Framework
         * @access public
         * 
         * @return KPF_Main Returns the instance of this class
         */
        public function initialize(): KPF_Main {
            if( is_null( $this->_instance ) ) {
                $this->_instance = new self();
            }
            return $this->_instance;
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
         * 
         * @return void Returns nothing
         */
        private function define_constants(): void {
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
         * 
         * @return void Returns nothing
         */
        private function init_hooks(): void {

            // Load includes after theme setup
            add_action( 'after_setup_theme', function() { $this -> load_includes( ); }, 5 );
            
            // Initialize theme settings
            add_action( 'after_setup_theme', function() { $this -> init_settings( ); }, 10 );
            
            // Enqueue assets
            add_action( 'wp_enqueue_scripts', function() { $this -> enqueue_assets( ); }, 10 );
            
            // Admin assets
            add_action( 'admin_enqueue_scripts', function() { $this -> admin_enqueue_assets( ); }, 10 );

        }

        /**
         * Load include files
         * 
         * @author Kevin Pirnie <iam@kevinpirnie.com>
         * @copyright 2025 Kevin Pirnie
         * 
         * @since 1.0.1
         * @package KP Theme Framework
         * @access private
         * 
         * @return void Returns nothing
         */
        private function load_includes(): void {

            // include the autoloader
            include_once KPF_PATH . '/vendor/autoload.php';
        }

        /**
         * Initialize theme settings
         * 
         * @author Kevin Pirnie <iam@kevinpirnie.com>
         * @copyright 2025 Kevin Pirnie
         * 
         * @since 1.0.1
         * @package KP Theme Framework
         * @access private
         * 
         * @return void Returns nothing
         */
        private function init_settings(): void {

            // Initialize the settings page
            if( class_exists( 'KPF_Settings' ) ) {
                KPF_Settings::instance();
            }
        }

        /**
         * Enqueue frontend assets
         * 
         * @author Kevin Pirnie <iam@kevinpirnie.com>
         * @copyright 2025 Kevin Pirnie
         * 
         * @since 1.0.1
         * @package KP Theme Framework
         * @access private
         * 
         * @return void Returns nothing
         */
        private function enqueue_assets(): void {

            // Load the selected CSS framework
            if( class_exists( 'KPF_Framework_Loader' ) ) {
                KPF_Framework_Loader::instance()->enqueue_framework();
            }

            // Theme stylesheet
            wp_enqueue_style( 
                'kpf-style', 
                KPF_URL . '/style.css', 
                [], 
                KPF_VERSION 
            );

            // Theme custom CSS (built from Tailwind if selected)
            if( file_exists( KPF_PATH . '/assets/css/theme.css' ) ) {
                wp_enqueue_style( 
                    'kpf-theme-css', 
                    KPF_ASSETS_URL . '/css/theme.css', 
                    [], 
                    KPF_VERSION 
                );
            }

            // Theme JS
            if( file_exists( KPF_PATH . '/assets/js/theme.js' ) ) {
                wp_enqueue_script( 
                    'kpf-theme-js', 
                    KPF_ASSETS_URL . '/js/theme.js', 
                    [], 
                    KPF_VERSION, 
                    true 
                );
            }
        }

        /**
         * Enqueue admin assets
         * 
         * @author Kevin Pirnie <iam@kevinpirnie.com>
         * @copyright 2025 Kevin Pirnie
         * 
         * @since 1.0.1
         * @package KP Theme Framework
         * @access private
         * 
         * @return void Returns nothing
         */
        private function admin_enqueue_assets(): void {

            // Admin styles if needed
            if( file_exists( KPF_PATH . '/assets/css/admin.css' ) ) {
                wp_enqueue_style( 
                    'kpf-admin-css', 
                    KPF_ASSETS_URL . '/css/admin.css', 
                    [], 
                    KPF_VERSION 
                );
            }
        }

    }

}