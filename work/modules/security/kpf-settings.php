<?php
/**
 * Security Module Settings
 * 
 * Handles the security settings tab
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
if( ! class_exists( 'KPF_Module_Security_Settings' ) ) {

    /**
     * Class KPF_Module_Security_Settings
     * 
     * @author Kevin Pirnie <iam@kevinpirnie.com>
     * @copyright 2025 Kevin Pirnie
     * 
     * @since 1.0.1
     * @package KP Theme Framework
     * @access public
     * 
     */
    class KPF_Module_Security_Settings extends KPF_Module_Base {

        /**
         * get_tab_config
         * 
         * Returns the tab configuration for the security module
         * 
         * @return array The tab configuration
         */
        public function get_tab_config( ): array {

            return [
                'title'    => __( 'Security', 'kpf' ),
                'sections' => [
                    'security' => [
                        'fields' => $this->get_fields( ),
                    ],
                ],
            ];

        }

        /**
         * get_fields
         * 
         * Returns the security settings fields
         * 
         * @access private
         * 
         * @return array The fields configuration
         */
        private function get_fields( ): array {

            return [
                $this->get_rest_api_field( ),
                $this->get_app_password_field( ),
                $this->get_feeds_field( ),
                $this->get_rpc_field( ),
                $this->get_identifiers_field( ),
                $this->get_adminbar_field( ),
                $this->get_commenting_field( ),
                $this->get_commenting_posttypes_field( ),
            ];

        }

        /**
         * get_rest_api_field
         * 
         * Returns the REST API field configuration
         * 
         * @access private
         * 
         * @return array The field configuration
         */
        private function get_rest_api_field( ): array {

            return [
                'id'          => 'kpf_sec_rest',
                'type'        => 'radio',
                'inline'      => true,
                'label'       => __( 'REST API?', 'kpf' ),
                'description' => __( 'Should we disable the REST API?', 'kpf' ),
                'options'     => [
                    2 => __( 'Get Rid of It!', 'kpf' ),
                    1 => __( 'Only on the Front-End', 'kpf' ),
                    0 => __( 'No Way!', 'kpf' ),
                ],
                'default'     => 1,
            ];

        }

        /**
         * get_app_password_field
         * 
         * Returns the Application Passwords field configuration
         * 
         * @access private
         * 
         * @return array The field configuration
         */
        private function get_app_password_field( ): array {

            return [
                'id'          => 'kpf_sec_app_password',
                'type'        => 'switch',
                'label'       => __( 'Application Passwords?', 'kpf' ),
                'description' => __( 'Should we disable Application Passwords?', 'kpf' ),
                'on_label'    => __( 'Yes', 'kpf' ),
                'off_label'   => __( 'No', 'kpf' ),
                'default'     => true,
            ];

        }

        /**
         * get_feeds_field
         * 
         * Returns the RSS Feeds field configuration
         * 
         * @access private
         * 
         * @return array The field configuration
         */
        private function get_feeds_field( ): array {

            return [
                'id'          => 'kpf_sec_remove_feeds',
                'type'        => 'switch',
                'label'       => __( 'Remove Feeds?', 'kpf' ),
                'description' => __( 'Should we remove all RSS Feeds?', 'kpf' ),
                'on_label'    => __( 'Yes', 'kpf' ),
                'off_label'   => __( 'No', 'kpf' ),
                'default'     => false,
            ];

        }

        /**
         * get_rpc_field
         * 
         * Returns the XML RPC field configuration
         * 
         * @access private
         * 
         * @return array The field configuration
         */
        private function get_rpc_field( ): array {

            return [
                'id'        => 'kpf_sec_remove_rpc',
                'type'      => 'switch',
                'label'     => __( 'Remove RPC?', 'kpf' ),
                'sublabel'  => __( 'Should we remove the XML RPC?', 'kpf' ),
                'on_label'  => __( 'Yes', 'kpf' ),
                'off_label' => __( 'No', 'kpf' ),
                'default'   => true,
            ];

        }

        /**
         * get_identifiers_field
         * 
         * Returns the WordPress Identifiers field configuration
         * 
         * @access private
         * 
         * @return array The field configuration
         */
        private function get_identifiers_field( ): array {

            return [
                'id'          => 'kpf_sec_remove_identifiers',
                'type'        => 'switch',
                'label'       => __( 'Remove Identifiers?', 'kpf' ),
                'description' => __( 'Should we remove the WordPress Identifiers?', 'kpf' ),
                'on_label'    => __( 'Yes', 'kpf' ),
                'off_label'   => __( 'No', 'kpf' ),
                'default'     => false,
            ];

        }

        /**
         * get_adminbar_field
         * 
         * Returns the Admin Bar field configuration
         * 
         * @access private
         * 
         * @return array The field configuration
         */
        private function get_adminbar_field( ): array {

            return [
                'id'          => 'kpf_sec_remove_adminbar',
                'type'        => 'switch',
                'label'       => __( 'Remove Admin-Bar?', 'kpf' ),
                'description' => __( 'Should we remove the admin bar on the front-end?', 'kpf' ),
                'on_label'    => __( 'Yes', 'kpf' ),
                'off_label'   => __( 'No', 'kpf' ),
                'default'     => true,
            ];

        }

        /**
         * get_commenting_field
         * 
         * Returns the Commenting field configuration
         * 
         * @access private
         * 
         * @return array The field configuration
         */
        private function get_commenting_field( ): array {

            return [
                'id'          => 'kpf_sec_remove_commenting',
                'type'        => 'radio',
                'inline'      => true,
                'label'       => __( 'Remove Commenting?', 'kpf' ),
                'description' => __( 'Should we remove commenting?', 'kpf' ),
                'options'     => [
                    2 => __( 'Get Rid of It!', 'kpf' ),
                    1 => __( 'Only for the Selected Post Types!', 'kpf' ),
                    0 => __( 'No Way!', 'kpf' ),
                ],
                'default'     => 0,
            ];

        }

        /**
         * get_commenting_posttypes_field
         * 
         * Returns the Commenting Post Types field configuration
         * 
         * @access private
         * 
         * @return array The field configuration
         */
        private function get_commenting_posttypes_field( ): array {

            return [
                'id'          => 'kpf_sec_remove_commenting_posttypes',
                'type'        => 'multiselect',
                'label'       => __( 'Post Types', 'kpf' ),
                'description' => __( 'This will remove the commenting capabilities from the selected post types.', 'kpf' ),
                'options'     => $this->get_all_post_types( ),
                'size'        => 100,
                'conditional' => [
                    'field'     => 'kpf_sec_remove_commenting',
                    'value'     => '1',
                    'condition' => '==',
                ],
            ];

        }

    }

}