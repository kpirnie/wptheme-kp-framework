<?php
/**
 * Module Registry Class
 * 
 * Handles module registration, permission checks, and initialization
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
if( ! class_exists( 'KPF_Module_Registry' ) ) {

    /**
     * Class KPF_Module_Registry
     * 
     * @author Kevin Pirnie <iam@kevinpirnie.com>
     * @copyright 2025 Kevin Pirnie
     * 
     * @since 1.0.1
     * @package KP Theme Framework
     * @access public
     * 
     */
    class KPF_Module_Registry {

        /**
         * Singleton instance
         * 
         * @var KPF_Module_Registry|null
         */
        private static ?KPF_Module_Registry $instance = null;

        /**
         * Registered modules
         * 
         * @var array
         */
        private array $modules = [];

        /**
         * Registered settings modules
         * 
         * @var array
         */
        private array $settings_modules = [];

        /**
         * Registered frontend modules
         * 
         * @var array
         */
        private array $frontend_modules = [];

        /**
         * Registered documentation modules
         * 
         * @var array
         */
        private array $documentation_modules = [];

        /**
         * Whether settings modules have been initialized
         * 
         * @var bool
         */
        private bool $settings_initialized = false;

        /**
         * get_instance
         * 
         * Returns the singleton instance
         * 
         * @return KPF_Module_Registry
         */
        public static function get_instance( ): KPF_Module_Registry {

            if( self::$instance === null ) {
                self::$instance = new self( );
            }

            return self::$instance;

        }

        /**
         * Class constructor
         * 
         * @access private
         */
        private function __construct( ) {

            // register core modules
            $this->register_core_modules( );

            // initialize frontend modules
            add_action( 'init', [ $this, 'init_frontend_modules' ] );

        }

        /**
         * register_core_modules
         * 
         * Registers all core framework modules
         * 
         * @access private
         * 
         * @return void
         */
        private function register_core_modules( ): void {

            // define core modules in priority order
            // permissions must be first as other modules depend on it
            $core_modules = [
                'permissions' => [
                    'name'           => __( 'Permissions', 'kpf' ),
                    'permission_key' => null, // always accessible to admins
                    'has_settings'   => true,
                    'has_frontend'   => false,
                    'has_docs'       => false,
                ],
                'security' => [
                    'name'           => __( 'Security', 'kpf' ),
                    'permission_key' => 'security',
                    'has_settings'   => true,
                    'has_frontend'   => true,
                    'has_docs'       => true,
                ],
                'framework' => [
                    'name'           => __( 'Framework', 'kpf' ),
                    'permission_key' => 'framework',
                    'has_settings'   => true,
                    'has_frontend'   => true,
                    'has_docs'       => true,
                ],
                'imagery' => [
                    'name'           => __( 'Imagery', 'kpf' ),
                    'permission_key' => 'imagery',
                    'has_settings'   => true,
                    'has_frontend'   => true,
                    'has_docs'       => true,
                ],
                'content' => [
                    'name'           => __( 'Content', 'kpf' ),
                    'permission_key' => 'content',
                    'has_settings'   => true,
                    'has_frontend'   => true,
                    'has_docs'       => true,
                ],
                'performance' => [
                    'name'           => __( 'Performance', 'kpf' ),
                    'permission_key' => 'performance',
                    'has_settings'   => true,
                    'has_frontend'   => true,
                    'has_docs'       => true,
                ],
                'smtp' => [
                    'name'           => __( 'SMTP', 'kpf' ),
                    'permission_key' => 'smtp',
                    'has_settings'   => true,
                    'has_frontend'   => true,
                    'has_docs'       => true,
                ],
                'cookie-notice' => [
                    'name'           => __( 'Cookie Notice', 'kpf' ),
                    'permission_key' => 'cnotice',
                    'has_settings'   => true,
                    'has_frontend'   => true,
                    'has_docs'       => true,
                ],
            ];

            // allow filtering of core modules
            $core_modules = apply_filters( 'kpf_core_modules', $core_modules );

            // register each module
            foreach( $core_modules as $key => $config ) {
                $this->register_module( $key, $config );
            }

        }

        /**
         * register_module
         * 
         * Registers a single module
         * 
         * @param string $key The module key
         * @param array $config The module configuration
         * 
         * @return void
         */
        public function register_module( string $key, array $config ): void {

            $this->modules[$key] = $config;

        }

        /**
         * init_frontend_modules
         * 
         * Initializes frontend modules
         * 
         * @return void
         */
        public function init_frontend_modules( ): void {

            // don't load frontend modules in admin
            if( is_admin( ) ) {
                return;
            }

            foreach( $this->modules as $key => $config ) {

                if( ! $config['has_frontend'] ) {
                    continue;
                }

                $class_name = $this->get_frontend_class_name( $key );

                if( class_exists( $class_name ) ) {
                    $this->frontend_modules[$key] = new $class_name( );
                }

            }

        }

        /**
         * init_settings_modules
         * 
         * Initializes settings modules
         * 
         * @return void
         */
        public function init_settings_modules( ): void {

            if( $this->settings_initialized ) {
                return;
            }

            if( ! is_admin( ) ) {
                return;
            }

            foreach( $this->modules as $key => $config ) {

                if( ! $config['has_settings'] ) {
                    continue;
                }

                // check permissions (null permission_key means admin-only)
                if( $config['permission_key'] !== null && ! $this->user_can_access_module( $config['permission_key'] ) ) {
                    continue;
                }

                $class_name = $this->get_settings_class_name( $key );

                if( class_exists( $class_name ) ) {
                    $this->settings_modules[$key] = new $class_name( );
                }

            }

            $this->settings_initialized = true;

        }

        /**
         * user_can_access_module
         * 
         * Checks if current user can access a module
         * 
         * @param string $permission_key The permission key to check
         * 
         * @return bool
         */
        private function user_can_access_module( string $permission_key ): bool {

            // admins and super admins always have access
            if( current_user_can( 'administrator' ) || is_super_admin( ) ) {
                return true;
            }

            $settings = get_option( 'kpf_settings', [] );

            // check user-level permissions
            $user_key = 'kpf_perms_users_' . $permission_key;
            if( isset( $settings[$user_key] ) && is_array( $settings[$user_key] ) ) {
                if( in_array( get_current_user_id( ), $settings[$user_key], true ) ) {
                    return true;
                }
            }

            // check role-level permissions
            $role_key = 'kpf_perms_role_' . $permission_key;
            if( isset( $settings[$role_key] ) && is_array( $settings[$role_key] ) ) {
                $user = wp_get_current_user( );
                foreach( $user->roles as $role ) {
                    if( in_array( $role, $settings[$role_key], true ) ) {
                        return true;
                    }
                }
            }

            return false;

        }

        /**
         * get_settings_class_name
         * 
         * Generates the settings class name from module key
         * 
         * @param string $key The module key
         * 
         * @return string The class name
         */
        private function get_settings_class_name( string $key ): string {

            $formatted = str_replace( '-', '_', $key );
            $formatted = ucwords( $formatted, '_' );

            return 'KPF_Module_' . $formatted . '_Settings';

        }

        /**
         * get_frontend_class_name
         * 
         * Generates the frontend class name from module key
         * 
         * @param string $key The module key
         * 
         * @return string The class name
         */
        private function get_frontend_class_name( string $key ): string {

            $formatted = str_replace( '-', '_', $key );
            $formatted = ucwords( $formatted, '_' );

            return 'KPF_Module_' . $formatted . '_Frontend';

        }

        /**
         * get_documentation_class_name
         * 
         * Generates the documentation class name from module key
         * 
         * @param string $key The module key
         * 
         * @return string The class name
         */
        private function get_documentation_class_name( string $key ): string {

            $formatted = str_replace( '-', '_', $key );
            $formatted = ucwords( $formatted, '_' );

            return 'KPF_Module_' . $formatted . '_Documentation';

        }

        /**
         * get_settings_tabs
         * 
         * Collects all settings tabs from registered settings modules
         * 
         * @return array The settings tabs
         */
        public function get_settings_tabs( ): array {

            // ensure settings modules are initialized
            $this->init_settings_modules( );

            $tabs = [];

            foreach( $this->settings_modules as $key => $module ) {
                if( method_exists( $module, 'get_tab_config' ) ) {
                    $tabs[$key] = $module->get_tab_config( );
                }
            }

            return $tabs;

        }

        /**
         * get_registered_modules
         * 
         * Returns all registered modules
         * 
         * @return array
         */
        public function get_registered_modules( ): array {

            return $this->modules;

        }

        /**
         * get_settings_modules
         * 
         * Returns initialized settings modules
         * 
         * @return array
         */
        public function get_settings_modules( ): array {

            return $this->settings_modules;

        }

        /**
         * get_frontend_modules
         * 
         * Returns initialized frontend modules
         * 
         * @return array
         */
        public function get_frontend_modules( ): array {

            return $this->frontend_modules;

        }

    }

}