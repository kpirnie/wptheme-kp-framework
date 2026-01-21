<?php
/**
 * Theme Settings Class
 * 
 * Handles the theme settings page creation
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

// pull our field framework
use \KP\WPFieldFramework\Loader;

// make sure we aren't loading in the class multiple times
if( ! class_exists( 'KPF_Settings' ) ) {

    /**
     * Class KPF_Settings
     * 
     * @author Kevin Pirnie <iam@kevinpirnie.com>
     * @copyright 2025 Kevin Pirnie
     * 
     * @since 1.0.1
     * @package KP Theme Framework
     * @access public
     * 
     */
    class KPF_Settings {

        /**
         * The field framework instance
         * 
         * @var \KP\WPFieldFramework\Framework|null
         */
        private ?\KP\WPFieldFramework\Framework $fw = null;

        /**
         * The module registry instance
         * 
         * @var KPF_Module_Registry|null
         */
        private ?KPF_Module_Registry $registry = null;

        /**
         * Class constructor
         * 
         * Setup the object
         * 
         * @internal
         */
        public function __construct( ) {

            // load up our framework
            $this->fw = Loader::init( );

            // get the module registry
            $this->registry = KPF_Module_Registry::get_instance( );

            // add in the theme settings
            add_action( 'admin_menu', [ $this, 'add_theme_settings' ], 20 );

        }

        /**
         * add_theme_settings
         * 
         * Creates the theme settings page
         * 
         * @author Kevin Pirnie <iam@kevinpirnie.com>
         * @copyright 2025 Kevin Pirnie
         * 
         * @since 1.0.1
         * @package KP Theme Framework
         * @access public
         * 
         * @return void Returns nothing
         */
        public function add_theme_settings( ): void {

            $key = 'kpf_settings';
            $tabs = $this->registry->get_settings_tabs( );

            if( empty( $tabs ) ) {
                return;
            }

            $page = $this->fw->addOptionsPage( [
                'option_key'         => $key,
                'page_title'         => __( 'KP Framework Theme Settings', 'kpf' ),
                'menu_title'         => __( 'KPF Settings', 'kpf' ),
                'capability'         => 'list_users',
                'menu_slug'          => 'kpf-settings',
                'icon_url'           => 'dashicons-vault',
                'position'           => 2,
                'tabs'               => $tabs,
                'save_button'        => __( 'Save Your Settings', 'kpf' ),
                'footer_text'        => $this->get_footer_text( ),
                'show_export_import' => true,
                'autoload'           => false, // false, true, null
            ] );

            // Manually register since we missed the framework's admin_menu hook
            $page->register( );

        }

        /**
         * get_footer_text
         * 
         * Returns the footer text for the settings page
         * 
         * @access private
         * 
         * @return string The footer HTML
         */
        private function get_footer_text( ): string {

            return sprintf(
                '<p class="alignright">%s &copy; %s <a href="https://kevinpirnie.com" target="_blank">Kevin Pirnie</a></p>',
                __( 'Copyright', 'kpf' ),
                date( 'Y' )
            );

        }

    }

}