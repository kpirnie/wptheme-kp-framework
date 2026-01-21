<?php
/**
 * Module Base Class
 * 
 * Provides shared functionality for all modules
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
if( ! class_exists( 'KPF_Module_Base' ) ) {

    /**
     * Class KPF_Module_Base
     * 
     * @author Kevin Pirnie <iam@kevinpirnie.com>
     * @copyright 2025 Kevin Pirnie
     * 
     * @since 1.0.1
     * @package KP Theme Framework
     * @access public
     * 
     */
    class KPF_Module_Base {

        /**
         * Static cache for expensive operations
         * 
         * @var array
         */
        protected static array $cache = [];

        /**
         * get_cached
         * 
         * Retrieves a cached value or executes callback and caches result
         * 
         * @param string $key The cache key
         * @param callable $callback The callback to execute if not cached
         * 
         * @return mixed The cached or freshly computed value
         */
        protected function get_cached( string $key, callable $callback ): mixed {

            if( ! isset( self::$cache[$key] ) ) {
                self::$cache[$key] = $callback( );
            }

            return self::$cache[$key];

        }

        /**
         * clear_cache
         * 
         * Clears the static cache
         * 
         * @param string|null $key Optional specific key to clear
         * 
         * @return void
         */
        protected function clear_cache( ?string $key = null ): void {

            if( $key !== null ) {
                unset( self::$cache[$key] );
            } else {
                self::$cache = [];
            }

        }

        /**
         * user_can_access
         * 
         * Checks if the current user has access to a module
         * 
         * @param string $permission_key The permission key to check
         * 
         * @return bool True if user can access, false otherwise
         */
        protected function user_can_access( string $permission_key ): bool {

            // admins and super admins always have access
            if( current_user_can( 'administrator' ) || is_super_admin( ) ) {
                return true;
            }

            // get the settings
            $settings = get_option( 'kpf_settings', [] );

            // check user-level permissions first
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
         * get_all_roles
         * 
         * Get all of the sites user roles (excluding administrator)
         * 
         * @return array Returns the user roles
         */
        protected function get_all_roles( ): array {

            return $this->get_cached( 'roles', function( ) {

                global $wp_roles;
                $ret = $wp_roles->get_names( );
                unset( $ret['administrator'] );

                return $ret;

            });

        }

        /**
         * get_all_users
         * 
         * Get all users for selection dropdowns
         * 
         * @return array Returns array of user ID => display name
         */
        protected function get_all_users( ): array {

            return $this->get_cached( 'users', function( ) {

                $ret = [];
                $users = get_users( [
                    'fields'  => [ 'ID', 'display_name' ],
                    'orderby' => 'display_name',
                    'order'   => 'ASC'
                ] );

                foreach( $users as $user ) {
                    $ret[$user->ID] = $user->display_name;
                }

                return $ret;

            });

        }

        /**
         * get_all_post_types
         * 
         * Get all of the sites post types (built-in and custom)
         * 
         * @return array Returns the post types
         */
        protected function get_all_post_types( ): array {

            return $this->get_cached( 'post_types', function( ) {

                $ret = [];
                $post_types = get_post_types( [], 'objects' );

                foreach( $post_types as $pt ) {
                    $labels = get_post_type_labels( $pt );
                    $ret[esc_attr( $pt->name )] = esc_html__( $labels->name, 'kpf' );
                }

                return $ret;

            });

        }

        /**
         * get_current_image_sizes
         * 
         * Gets a list of all registered WordPress image sizes
         * 
         * @return string Returns a formatted string of all currently registered image sizes
         */
        protected function get_current_image_sizes( ): string {

            global $_wp_additional_image_sizes;

            $ret = '';
            $sizes = [];
            $get_image_sizes = get_intermediate_image_sizes( );

            foreach( $get_image_sizes as $s ) {

                $sizes[$s] = [ 0, 0 ];
                
                if( in_array( $s, [ 'thumbnail', 'medium', 'medium_large', 'large' ], true ) ) {
                    $sizes[$s][0] = get_option( $s . '_size_w' );
                    $sizes[$s][1] = get_option( $s . '_size_h' );
                } else {
                    if( isset( $_wp_additional_image_sizes ) && isset( $_wp_additional_image_sizes[$s] ) ) {
                        $sizes[$s] = [
                            $_wp_additional_image_sizes[$s]['width'],
                            $_wp_additional_image_sizes[$s]['height'],
                        ];
                    }
                }

            }

            if( $sizes ) {
                foreach( $sizes as $size => $atts ) {
                    $ret .= '&nbsp;<strong>' . $size . ':</strong> (' . implode( 'x', $atts ) . ')<br />';
                }
            }
            
            return $ret;

        }

        /**
         * get_setting
         * 
         * Retrieves a specific setting value
         * 
         * @param string $key The setting key
         * @param mixed $default Default value if not set
         * 
         * @return mixed The setting value
         */
        protected function get_setting( string $key, mixed $default = null ): mixed {

            $settings = get_option( 'kpf_settings', [] );

            return $settings[$key] ?? $default;

        }

    }

}