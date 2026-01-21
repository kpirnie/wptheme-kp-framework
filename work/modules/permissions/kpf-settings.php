<?php
/**
 * Permissions Module Settings
 * 
 * Handles the permissions settings tab
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
if( ! class_exists( 'KPF_Module_Permissions_Settings' ) ) {

    /**
     * Class KPF_Module_Permissions_Settings
     * 
     * @author Kevin Pirnie <iam@kevinpirnie.com>
     * @copyright 2025 Kevin Pirnie
     * 
     * @since 1.0.1
     * @package KP Theme Framework
     * @access public
     * 
     */
    class KPF_Module_Permissions_Settings extends KPF_Module_Base {

        /**
         * get_tab_config
         * 
         * Returns the tab configuration for the permissions module
         * 
         * @return array The tab configuration
         */
        public function get_tab_config( ): array {

            return [
                'title'       => __( 'Permissions', 'kpf' ),
                'description' => __( 'Controls which settings are available to which Roles and Users.', 'kpf' ),
                'sections'    => [
                    'rolepermissions' => [
                        'fields' => [
                            $this->get_role_permissions_field( ),
                            $this->get_user_permissions_field( ),
                        ],
                    ],
                ],
            ];

        }

        /**
         * get_role_permissions_field
         * 
         * Returns the role permissions accordion field
         * 
         * @access private
         * 
         * @return array The field configuration
         */
        private function get_role_permissions_field( ): array {

            $roles = $this->get_all_roles( );

            return [
                'id'          => 'kpf_perms_roles',
                'label'       => __( 'Group Roles', 'kpf' ),
                'description' => __( 'Select which roles are allowed to manage each section. Admins and Super Admins are always allowed.', 'kpf' ),
                'type'        => 'accordion',
                'fields'      => [
                    [
                        'id'      => 'kpf_perms_role_security',
                        'type'    => 'multiselect',
                        'label'   => __( 'Security', 'kpf' ),
                        'options' => $roles,
                    ],
                    [
                        'id'      => 'kpf_perms_role_framework',
                        'type'    => 'multiselect',
                        'label'   => __( 'Framework', 'kpf' ),
                        'options' => $roles,
                    ],
                    [
                        'id'      => 'kpf_perms_role_imagery',
                        'type'    => 'multiselect',
                        'label'   => __( 'Imagery', 'kpf' ),
                        'options' => $roles,
                    ],
                    [
                        'id'      => 'kpf_perms_role_content',
                        'type'    => 'multiselect',
                        'label'   => __( 'Content', 'kpf' ),
                        'options' => $roles,
                    ],
                    [
                        'id'      => 'kpf_perms_role_performance',
                        'type'    => 'multiselect',
                        'label'   => __( 'Performance', 'kpf' ),
                        'options' => $roles,
                    ],
                    [
                        'id'      => 'kpf_perms_role_smtp',
                        'type'    => 'multiselect',
                        'label'   => __( 'SMTP', 'kpf' ),
                        'options' => $roles,
                    ],
                    [
                        'id'      => 'kpf_perms_role_cnotice',
                        'type'    => 'multiselect',
                        'label'   => __( 'Cookie Notice', 'kpf' ),
                        'options' => $roles,
                    ],
                ],
            ];

        }

        /**
         * get_user_permissions_field
         * 
         * Returns the user permissions accordion field
         * 
         * @access private
         * 
         * @return array The field configuration
         */
        private function get_user_permissions_field( ): array {

            $users = $this->get_all_users( );
            $current_user_id = get_current_user_id( );

            return [
                'id'          => 'kpf_perms_users',
                'label'       => __( 'Group Users', 'kpf' ),
                'description' => __( 'Select which users are allowed to manage each section. You are automatically added by default.', 'kpf' ),
                'type'        => 'accordion',
                'fields'      => [
                    [
                        'id'      => 'kpf_perms_users_security',
                        'type'    => 'multiselect',
                        'label'   => __( 'Security', 'kpf' ),
                        'options' => $users,
                        'default' => [ $current_user_id ],
                    ],
                    [
                        'id'      => 'kpf_perms_users_framework',
                        'type'    => 'multiselect',
                        'label'   => __( 'Framework', 'kpf' ),
                        'options' => $users,
                        'default' => [ $current_user_id ],
                    ],
                    [
                        'id'      => 'kpf_perms_users_imagery',
                        'type'    => 'multiselect',
                        'label'   => __( 'Imagery', 'kpf' ),
                        'options' => $users,
                        'default' => [ $current_user_id ],
                    ],
                    [
                        'id'      => 'kpf_perms_users_content',
                        'type'    => 'multiselect',
                        'label'   => __( 'Content', 'kpf' ),
                        'options' => $users,
                        'default' => [ $current_user_id ],
                    ],
                    [
                        'id'      => 'kpf_perms_users_performance',
                        'type'    => 'multiselect',
                        'label'   => __( 'Performance', 'kpf' ),
                        'options' => $users,
                        'default' => [ $current_user_id ],
                    ],
                    [
                        'id'      => 'kpf_perms_users_smtp',
                        'type'    => 'multiselect',
                        'label'   => __( 'SMTP', 'kpf' ),
                        'options' => $users,
                        'default' => [ $current_user_id ],
                    ],
                    [
                        'id'      => 'kpf_perms_users_cnotice',
                        'type'    => 'multiselect',
                        'label'   => __( 'Cookie Notice', 'kpf' ),
                        'options' => $users,
                        'default' => [ $current_user_id ],
                    ],
                ],
            ];

        }

    }

}