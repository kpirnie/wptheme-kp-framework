<?php
/**
 * Framework Module Settings
 * 
 * Handles the CSS framework settings tab
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
if( ! class_exists( 'KPF_Module_Framework_Settings' ) ) {

    /**
     * Class KPF_Module_Framework_Settings
     * 
     * @author Kevin Pirnie <iam@kevinpirnie.com>
     * @copyright 2025 Kevin Pirnie
     * 
     * @since 1.0.1
     * @package KP Theme Framework
     * @access public
     * 
     */
    class KPF_Module_Framework_Settings extends KPF_Module_Base {

        /**
         * get_tab_config
         * 
         * Returns the tab configuration for the framework module
         * 
         * @return array The tab configuration
         */
        public function get_tab_config( ): array {

            return [
                'title'    => __( 'Framework', 'kpf' ),
                'sections' => [
                    'css_framework' => [
                        'fields' => $this->get_fields( ),
                    ],
                ],
            ];

        }

        /**
         * get_fields
         * 
         * Returns the framework settings fields
         * 
         * @access private
         * 
         * @return array The fields configuration
         */
        private function get_fields( ): array {

            return [
                $this->get_framework_selector_field( ),
                $this->get_bootstrap_version_field( ),
                $this->get_uikit_version_field( ),
                $this->get_tailwind_version_field( ),
                $this->get_foundation_version_field( ),
                $this->get_bulma_version_field( ),
                $this->get_materialize_version_field( ),
                $this->get_cdn_field( ),
                $this->get_tailwind_note_field( ),
            ];

        }

        /**
         * get_framework_selector_field
         * 
         * Returns the framework selector field configuration
         * 
         * @access private
         * 
         * @return array The field configuration
         */
        private function get_framework_selector_field( ): array {

            return [
                'id'          => 'kpf_fw_name',
                'type'        => 'select',
                'label'       => __( 'CSS Framework', 'kpf' ),
                'description' => __( 'Picking a framework here will automatically load in everything needed for you to utilize it.<br /><strong>NOTE: </strong>Once you make a selection, you will be able to choose the version to utilize, and whether or not you want to load it from the CDN.', 'kpf' ),
                'options'     => [
                    '0' => __( 'None', 'kpf' ),
                    '1' => __( 'Bootstrap', 'kpf' ),
                    '2' => __( 'UIKit', 'kpf' ),
                    '3' => __( 'Tailwind', 'kpf' ),
                    '4' => __( 'Foundation', 'kpf' ),
                    '5' => __( 'Bulma', 'kpf' ),
                    '6' => __( 'Materialize', 'kpf' ),
                ],
                'default'     => '0',
            ];

        }

        /**
         * get_bootstrap_version_field
         * 
         * Returns the Bootstrap version field configuration
         * 
         * @access private
         * 
         * @return array The field configuration
         */
        private function get_bootstrap_version_field( ): array {

            return [
                'id'          => 'kpf_fw_bs_ver',
                'type'        => 'select',
                'label'       => __( 'Framework Version', 'kpf' ),
                'description' => __( 'Select the framework version that you would like to utilize.', 'kpf' ),
                'options'     => [
                    'latest' => __( 'Latest', 'kpf' ),
                    '5.3'    => __( '5.3.3', 'kpf' ),
                    '5.2'    => __( '5.2.3', 'kpf' ),
                    '5.1'    => __( '5.1.3', 'kpf' ),
                    '5.0'    => __( '5.0.2', 'kpf' ),
                ],
                'conditional' => [
                    'field'     => 'kpf_fw_name',
                    'value'     => '1',
                    'condition' => '==',
                ],
            ];

        }

        /**
         * get_uikit_version_field
         * 
         * Returns the UIKit version field configuration
         * 
         * @access private
         * 
         * @return array The field configuration
         */
        private function get_uikit_version_field( ): array {

            return [
                'id'          => 'kpf_fw_uk_ver',
                'type'        => 'select',
                'label'       => __( 'Framework Version', 'kpf' ),
                'description' => __( 'Select the framework version that you would like to utilize.', 'kpf' ),
                'options'     => [
                    'latest' => __( 'Latest', 'kpf' ),
                    '3.21'   => __( '3.21.6', 'kpf' ),
                    '3.20'   => __( '3.20.8', 'kpf' ),
                    '3.19'   => __( '3.19.4', 'kpf' ),
                ],
                'conditional' => [
                    'field'     => 'kpf_fw_name',
                    'value'     => '2',
                    'condition' => '==',
                ],
            ];

        }

        /**
         * get_tailwind_version_field
         * 
         * Returns the Tailwind version field configuration
         * 
         * @access private
         * 
         * @return array The field configuration
         */
        private function get_tailwind_version_field( ): array {

            return [
                'id'          => 'kpf_fw_tw_ver',
                'type'        => 'select',
                'label'       => __( 'Framework Version', 'kpf' ),
                'description' => __( 'Select the framework version that you would like to utilize.', 'kpf' ),
                'options'     => [
                    'latest' => __( 'Latest', 'kpf' ),
                    '3.4'    => __( '3.4.17', 'kpf' ),
                    '3.3'    => __( '3.3.6', 'kpf' ),
                ],
                'conditional' => [
                    'field'     => 'kpf_fw_name',
                    'value'     => '3',
                    'condition' => '==',
                ],
            ];

        }

        /**
         * get_foundation_version_field
         * 
         * Returns the Foundation version field configuration
         * 
         * @access private
         * 
         * @return array The field configuration
         */
        private function get_foundation_version_field( ): array {

            return [
                'id'          => 'kpf_fw_f_ver',
                'type'        => 'select',
                'label'       => __( 'Framework Version', 'kpf' ),
                'description' => __( 'Select the framework version that you would like to utilize.', 'kpf' ),
                'options'     => [
                    'latest' => __( 'Latest', 'kpf' ),
                    '6.8'    => __( '6.8.1', 'kpf' ),
                    '6.7'    => __( '6.7.5', 'kpf' ),
                    '6.6'    => __( '6.6.3', 'kpf' ),
                ],
                'conditional' => [
                    'field'     => 'kpf_fw_name',
                    'value'     => '4',
                    'condition' => '==',
                ],
            ];

        }

        /**
         * get_bulma_version_field
         * 
         * Returns the Bulma version field configuration
         * 
         * @access private
         * 
         * @return array The field configuration
         */
        private function get_bulma_version_field( ): array {

            return [
                'id'          => 'kpf_fw_b_ver',
                'type'        => 'select',
                'label'       => __( 'Framework Version', 'kpf' ),
                'description' => __( 'Select the framework version that you would like to utilize.', 'kpf' ),
                'options'     => [
                    'latest' => __( 'Latest', 'kpf' ),
                    '1.0'    => __( '1.0.2', 'kpf' ),
                    '0.9'    => __( '0.9.4', 'kpf' ),
                ],
                'conditional' => [
                    'field'     => 'kpf_fw_name',
                    'value'     => '5',
                    'condition' => '==',
                ],
            ];

        }

        /**
         * get_materialize_version_field
         * 
         * Returns the Materialize version field configuration
         * 
         * @access private
         * 
         * @return array The field configuration
         */
        private function get_materialize_version_field( ): array {

            return [
                'id'          => 'kpf_fw_m_ver',
                'type'        => 'select',
                'label'       => __( 'Framework Version', 'kpf' ),
                'description' => __( 'Select the framework version that you would like to utilize.', 'kpf' ),
                'options'     => [
                    'latest'  => __( 'Latest', 'kpf' ),
                    '1.0'     => __( '1.0.0', 'kpf' ),
                    '0.100.2' => __( '0.100.2', 'kpf' ),
                ],
                'conditional' => [
                    'field'     => 'kpf_fw_name',
                    'value'     => '6',
                    'condition' => '==',
                ],
            ];

        }

        /**
         * get_cdn_field
         * 
         * Returns the CDN toggle field configuration
         * 
         * @access private
         * 
         * @return array The field configuration
         */
        private function get_cdn_field( ): array {

            return [
                'id'          => 'kpf_fw_cdn',
                'label'       => __( 'Load from CDN?', 'kpf' ),
                'type'        => 'switch',
                'description' => __( 'Should we load the framework from the CDN? (cdn.jsdelivr.net)', 'kpf' ),
                'on_label'    => __( 'Yes', 'kpf' ),
                'off_label'   => __( 'No', 'kpf' ),
                'default'     => true,
                'conditional' => [
                    'field'     => 'kpf_fw_name',
                    'value'     => [ '1', '2', '4', '5', '6' ],
                    'condition' => 'IN',
                ],
            ];

        }

        /**
         * get_tailwind_note_field
         * 
         * Returns the Tailwind note message field configuration
         * 
         * @access private
         * 
         * @return array The field configuration
         */
        private function get_tailwind_note_field( ): array {

            return [
                'id'           => 'kpf_fw_f_note',
                'type'         => 'message',
                'message_type' => 'warning',
                'content'      => __( 'Tailwind plays a bit differently, you will need to utilize it\'s build processes in order to use this framework.<br />See here for more information: <a href="https://tailwindcss.com/docs/installation/using-vite" target="_blank">https://tailwindcss.com/docs/installation/using-vite</a>', 'kpf' ),
                'conditional'  => [
                    'field'     => 'kpf_fw_name',
                    'value'     => '3',
                    'condition' => '==',
                ],
            ];

        }

    }

}