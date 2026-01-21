<?php
/**
 * SMTP Module Settings
 * 
 * Handles the SMTP settings tab
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
if( ! class_exists( 'KPF_Module_Smtp_Settings' ) ) {

    /**
     * Class KPF_Module_Smtp_Settings
     * 
     * @author Kevin Pirnie <iam@kevinpirnie.com>
     * @copyright 2025 Kevin Pirnie
     * 
     * @since 1.0.1
     * @package KP Theme Framework
     * @access public
     * 
     */
    class KPF_Module_Smtp_Settings extends KPF_Module_Base {

        /**
         * get_tab_config
         * 
         * Returns the tab configuration for the SMTP module
         * 
         * @return array The tab configuration
         */
        public function get_tab_config( ): array {

            return [
                'title'    => __( 'SMTP', 'kpf' ),
                'sections' => [
                    'smtp' => [
                        'fields' => $this->get_fields( ),
                    ],
                ],
            ];

        }

        /**
         * get_fields
         * 
         * Returns the SMTP settings fields
         * 
         * @access private
         * 
         * @return array The fields configuration
         */
        private function get_fields( ): array {

            return [
                $this->get_override_field( ),
                $this->get_force_from_field( ),
                $this->get_from_group_field( ),
                $this->get_server_group_field( ),
            ];

        }

        /**
         * get_override_field
         * 
         * Returns the override WordPress email field configuration
         * 
         * @access private
         * 
         * @return array The field configuration
         */
        private function get_override_field( ): array {

            return [
                'id'          => 'kpf_smtp_override',
                'label'       => __( 'Override WordPress?', 'kpf' ),
                'description' => __( 'Should we override WordPress\'s email sender?', 'kpf' ),
                'type'        => 'switch',
                'on_label'    => __( 'Yes', 'kpf' ),
                'off_label'   => __( 'No', 'kpf' ),
                'default'     => false,
            ];

        }

        /**
         * get_force_from_field
         * 
         * Returns the force from field configuration
         * 
         * @access private
         * 
         * @return array The field configuration
         */
        private function get_force_from_field( ): array {

            return [
                'id'          => 'kpf_smtp_force_from',
                'label'       => __( 'Force From?', 'kpf' ),
                'description' => __( 'Should the from email address be overridden?<br />If you do not, the from address will default to the username account you set below (if it is an email address), otherwise it will be set to the websites admin email address.', 'kpf' ),
                'type'        => 'switch',
                'on_label'    => __( 'Yes', 'kpf' ),
                'off_label'   => __( 'No', 'kpf' ),
                'default'     => false,
                'conditional' => [
                    'field'     => 'kpf_smtp_override',
                    'value'     => true,
                    'condition' => '==',
                ],
            ];

        }

        /**
         * get_from_group_field
         * 
         * Returns the from name/email group field configuration
         * 
         * @access private
         * 
         * @return array The field configuration
         */
        private function get_from_group_field( ): array {

            return [
                'id'          => 'kpf_smtp_from',
                'label'       => __( 'From', 'kpf' ),
                'type'        => 'group',
                'fields'      => [
                    [
                        'id'     => 'kpf_smtp_from_n',
                        'type'   => 'text',
                        'label'  => __( 'Name', 'kpf' ),
                        'inline' => true,
                    ],
                    [
                        'id'     => 'kpf_smtp_from_e',
                        'type'   => 'email',
                        'label'  => __( 'Email Address', 'kpf' ),
                        'inline' => true,
                    ],
                ],
                'conditional' => [
                    'field'     => 'kpf_smtp_force_from',
                    'value'     => true,
                    'condition' => '==',
                ],
            ];

        }

        /**
         * get_server_group_field
         * 
         * Returns the server information group field configuration
         * 
         * @access private
         * 
         * @return array The field configuration
         */
        private function get_server_group_field( ): array {

            return [
                'id'          => 'kpf_smtp_server',
                'label'       => __( 'Server Information', 'kpf' ),
                'sublabel'    => __( 'Please see your providers support pages for the information you will need here.', 'kpf' ),
                'type'        => 'group',
                'fields'      => [
                    [
                        'id'     => 'kpf_smtp_host',
                        'type'   => 'text',
                        'label'  => __( 'Server/Host', 'kpf' ),
                        'inline' => true,
                    ],
                    [
                        'id'      => 'kpf_smtp_port',
                        'type'    => 'text',
                        'label'   => __( 'Port', 'kpf' ),
                        'default' => 25,
                        'inline'  => true,
                    ],
                    [
                        'id'      => 'kpf_smtp_br1',
                        'type'    => 'html',
                        'content' => '<br />',
                    ],
                    [
                        'id'     => 'kpf_smtp_un',
                        'type'   => 'text',
                        'label'  => __( 'Username', 'kpf' ),
                        'inline' => true,
                    ],
                    [
                        'id'     => 'kpf_smtp_pw',
                        'type'   => 'password',
                        'label'  => __( 'Password', 'kpf' ),
                        'inline' => true,
                    ],
                    [
                        'id'      => 'kpf_smtp_br2',
                        'type'    => 'html',
                        'content' => '<br />',
                    ],
                    [
                        'id'          => 'kpf_smtp_html',
                        'label'       => __( 'Force HTML?', 'kpf' ),
                        'description' => __( 'Should emails sent out be converted to HTML format?', 'kpf' ),
                        'type'        => 'switch',
                        'on_label'    => __( 'Yes', 'kpf' ),
                        'off_label'   => __( 'No', 'kpf' ),
                        'default'     => true,
                        'inline'      => true,
                    ],
                    [
                        'id'      => 'kpf_smtp_security',
                        'label'   => __( 'Security Type?', 'kpf' ),
                        'type'    => 'radio',
                        'options' => [
                            '0' => __( 'None', 'kpf' ),
                            '1' => __( 'SSL', 'kpf' ),
                            '2' => __( 'STARTTLS', 'kpf' ),
                        ],
                        'inline'  => true,
                    ],
                ],
                'conditional' => [
                    'field'     => 'kpf_smtp_override',
                    'value'     => true,
                    'condition' => '==',
                ],
            ];

        }

    }

}